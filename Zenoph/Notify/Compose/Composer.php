<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Compose;
    
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Utils\PhoneUtil;
    use Zenoph\Notify\Enums\DestinationMode;
    USE Zenoph\Notify\Enums\NumberAddInfo;
    use Zenoph\Notify\Enums\DataContentType;
    use Zenoph\Notify\Compose\IComposer;
    use Zenoph\Notify\Store\UserData;
    use Zenoph\Notify\Store\AuthProfile;
    use Zenoph\Notify\Store\ComposerDestination;
    use Zenoph\Notify\Collections\ObjectStorage;
    use Zenoph\Notify\Collections\ComposerDestinationsList;
    
    abstract class Composer implements IComposer {
        protected $_message = null;
        protected $_notifyURL = null;
        protected $_notifyContentType = null;
        protected $_userData = null;
        protected $_destinations = null;
        protected $_messageIdsMap = null;
        protected $_destinationsKeyMap = null;
        protected $_scheduleDateTime = null;
        protected $_scheduleUTCOffset = null;
        protected $_category = null;

        const __CUSTOM_DATA_LABEL__ = "data";
        const __DEST_COMP_LIST_LABEL__ = 'compDestsList';
        const __DEST_COUNTRYCODE_LABEL__ = 'countryCode';

        
        public function __construct($authProfile = null) {
            if (!is_null($authProfile)){
                if ($authProfile instanceof AuthProfile === false)
                    throw new \Exception('Invalid parameter for initialising message object.');
                
                if (!$authProfile->authenticated())
                    throw new \Exception('User profile has not been authenticated.'); 
                
                $this->_userData = $authProfile->getUserData();
            }
            
            $this->_destinations = new ObjectStorage();
            $this->_messageIdsMap = array();
            $this->_destinationsKeyMap = array();
            $this->_notifyContentType = DataContentType::DCT_XML;
        }
        
        public function setUserData($ud){
            // ensure it is a valid UserData object
            if (is_null($ud) || $ud instanceof UserData === false)
                throw new \Exception('Invalid user data reference.');
            
            // set data
            $this->_userData = $ud;
        }

        public function getCategory() {
            return $this->_category;
        }
        
        public function getMessageId($phoneNumber) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for destination message identifier.');
            
            // destination should exist
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number' {$phoneNumber}' does not exist in the destinations list.");
                
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            // get destinations list for this particular phone number
            $compDestsStore = $this->getMappedDestinations($fmtdNumber);
            
            // we don't expect multiple items
            if ($compDestsStore->getCount() > 1)
                throw new \Exception("There are multiple composer destinations for phone number '{$fmtdNumber}'.");
                
            $compDestsArr = &$compDestsStore->getItems();
            $compDest = $compDestsArr[0];
            
            // return messageId
            return $compDest->getMessageId();
        }
        
        public function setMessage($message, $info = null) {
            if (is_null($message) || empty($message))
                throw new \Exception('Invalid message text or reference.');
            
            $this->_message = $message;
        }
        
        public function getMessage() {
            return $this->_message;
        }
        
        public function getDestinationCountry($phoneNumber) {
            if (is_null($this->_userData))
                return null;
            
            if (!$this->destinationExists($phoneNumber))
                return null;
            
            $numberInfo = $this->formatPhoneNumber($phoneNumber, false);
            $fmtdNumber = $numberInfo[0];
            $countryCode = $this->getDestinationCountryCode($fmtdNumber);
            
            if (is_null($countryCode))
                return null;  
            
            $routeFilters = $this->_userData->getRouteFilters();
            
            if (!is_null($routeFilters) && isset($routeFilters[$countryCode]))
                return $routeFilters[$countryCode]['countryName'];
            
            return null;
        }
        
        public function getDefaultDestinationCountry() {
            if (is_null($this->_userData))
                throw new \Exception('Default destination country has not been loaded.');
            
            $defRouteInfo = $this->_userData->getDefaultRouteInfo();
            $countryName = $defRouteInfo['countryName'];
            $countryCode = $defRouteInfo['countryCode'];
            $dialCode = $defRouteInfo['dialCode'];
            
            return array($countryName, $countryCode, $dialCode);
        }
        
        protected function getDestinationCountryCode($phoneNumber){
            $countryCode = null;
            
            // If the phone number has already been added, then quickly get the country code
            if ($this->formattedDestinationExists($phoneNumber)){
                $countryCode = $this->_destinationsKeyMap[$phoneNumber][self::__DEST_COUNTRYCODE_LABEL__];
            }
            else {
                $numberInfo = $this->formatPhoneNumber($phoneNumber, false);
                
                if (is_null($numberInfo))
                    return null;
                
                // use the country code to get the country name
                $countryCode = $numberInfo[1];
            }
            
            return $countryCode;
        }

        public function setNotifyURL($url, $contentType) {
            if (is_null($url) || empty($url)){
                $this->_notifyURL = null;
                return;
            }
            
            // the content format must be one of the application acceptable data formats.
            if (is_null($contentType) || empty($contentType))
                throw new \Exception('Invalid reference to data content format specifier for notifying status.');
            
            // for delivery response, we only allow XML of JSON
            if ($contentType != DataContentType::DCT_XML && $contentType != DataContentType::DCT_JSON && $contentType != DataContentType::DCT_WWW_URL_ENCODED)
                throw new \Exception("Invalid data content format specifier for delivery status notifications.");
            
            // set them
            $this->_notifyURL = $url;
            $this->_notifyContentType = $contentType;
        }

        public function getDestinationWriteMode($phoneNumber) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for destination mode.');
            
            // destination must exist
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist in the destinations list.");
                
            // format in international format
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            $compDestsStore = $this->getMappedDestinations($fmtdNumber);
            
            // Here, message is not personalised message. For non-personalised
            // text messages, there shouldn't be multiple items
            if ($compDestsStore->getCount() > 1)
                throw new \Exception('There are multiple destination data information.');
            
            $compDestsArr = &$compDestsStore->getItems();
            $compDest = &$compDestsArr[0];
            
            // return destination mode
            return $compDest->getWriteMode();
        }
        
        public function getDestinationWriteModeById($messageId) {
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid message identifier for destination mode.');
            
            // it should exit in the message Ids list
            if (!array_key_exists($messageId, $this->_messageIdsMap))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            // return the destination mode using the message id
            return $this->_messageIdsMap[$messageId]->getWriteMode();
        }
        
        protected function getMappedDestinations($phoneNumber) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for destination data container.');
            
            if (!array_key_exists($phoneNumber, $this->_destinationsKeyMap))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist in the destinations list.");

            return $this->_destinationsKeyMap[$phoneNumber][self::__DEST_COMP_LIST_LABEL__];
        }
        
        protected function getMappedDestinationById($messageId){
            if (!$this->messageIdExists($messageId))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            // we will need the phone number
            return $this->_messageIdsMap[$messageId];
        }
        
        protected function getComposerDestinationById($messageId){
            return $this->getMappedDestinationById($messageId);
        }
        
        protected function getComposerDestinations($phoneNumber){
            return $this->getMappedDestinations($phoneNumber);
        }
        
        protected function formattedDestinationExists($phoneNumber){
            if (is_null($this->_destinationsKeyMap))
                return false;
            
            // see if it exists.
            return array_key_exists($phoneNumber, $this->_destinationsKeyMap);
        }
        
        public function destinationExists($phonenum) {
            if (is_null($phonenum) || empty($phonenum))
                throw new \Exception('Invalid reference to phone number for checking existence in destinations list.');
            
            $numberInfo = $this->formatPhoneNumber($phonenum);
            
            if (is_null($numberInfo))
                return false;
            
            // check with the formatted phone number.
            return $this->formattedDestinationExists($numberInfo[0]);
        }
        
        protected function formatPhoneNumber($phoneNumber, $throwEx = false) {
            if (is_null($this->_userData))
                return UserData::createDestinationCountryMap ($phoneNumber, null);
            else
                return $this->_userData->formatPhoneNumber($phoneNumber, $throwEx);
        }
        
        protected function getFormattedPhoneNumber($phoneNumber){
            // validate inputs
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for getting destination message identifier.');

            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist.");
                
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            return $numberInfo[0];
        }
        
        public function clearDestinations() {
            unset($this->_messageIdsMap);
            unset($this->_destinationsKeyMap);
            $this->_destinations->clear();
            
            $this->_messageIdsMap = $this->_destinationsKeyMap = array();
        }
        
        public function addDestinationsFromTextStream(&$str) {
            if (is_null($str) || empty($str))
                throw new \Exception('Invalid text stream for adding message destinations.');
            
            $addCount = 0;
            $validList = PhoneUtil::extractPhoneNumbers($str);
            
            if (!is_null($validList) && is_array($validList)){
                for ($i = 0; $i < count($validList); ++$i){
                    $phoneNum = $validList[$i];
                    
                    if ($this->addDestination($phoneNum, false) == NumberAddInfo::NAI_OK)
                        ++$addCount;
                }
            }
            
            return $addCount;
        }
        
        public function addDestinationsFromCollection(&$phoneNumbers, $throwEx = false) {
            if (is_null($phoneNumbers) || !is_array($phoneNumbers)) {
                if (!$throwEx)
                    return 0;
                
                throw new \Exception('Invalid collection for adding destinations.');
            }
            
            if (!is_bool($throwEx))
                throw new \Exception("Invalid argument for exception handling.");
            
            $count = 0;
            
            foreach ($phoneNumbers as $phoneNum){
                if ($this->addDestination($phoneNum, $throwEx) == NumberAddInfo::NAI_OK){
                    $count++;
                }
            }
            
            return $count;
        }
        
        public function addDestination($phoneNumber, $throwEx = true, $messageId = null) {
            if (is_null($phoneNumber) || empty($phoneNumber)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_INVALID;
                
                throw new \Exception('Invalid value for adding message destination.');
            }
            
            if (!PhoneUtil::isValidPhoneNumber($phoneNumber)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_INVALID;
                
                throw new \Exception("'{$phoneNumber}' is not a valid phone number.");
            }
            
            $numAddInfo = null;
            
            if (!is_null($messageId) && !empty($messageId)) {
                if (($numAddInfo = $this->validateCustomMessageId($messageId, $throwEx)) != NumberAddInfo::NAI_OK)
                    return $numAddInfo;
            }
            
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            
            if (is_null($numberInfo)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_ROUTE;

                throw new \Exception("'{$phoneNumber}' is not a valid destination on permitted routes.");
            }
            
            $fmtdNumber = $numberInfo[0];
            $countryCode = $numberInfo[1];
            
            // destination must not already exist
            if ($this->formattedDestinationExists($fmtdNumber)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_EXISTS;
                
                throw new \Exception("Phone number '{$phoneNumber}' already exists.");
            }

            // add and return status
            return $this->addDestinationInfo($fmtdNumber, $countryCode, $messageId, null);
        }
        
        protected function addDestinationInfo($phoneNumber, $countryCode, $messageId, $destData){
            // Here, we will be adding a destination
            $destMode = DestinationMode::DM_ADD;
            
            // create the composer destination
            $compDest = $this->createComposerDestination($phoneNumber, $messageId, $destMode, $destData);
            $this->addComposerDestination($compDest, $countryCode);
            
            // it was added successfully
            return NumberAddInfo::NAI_OK;
        }
        
        protected function addComposerDestinationsList($compDestsList, $countryCode){
            if (is_null($compDestsList))
                throw new \Exception('Invalid reference for adding composer destinations collection.');
            
            foreach ($compDestsList as $compdest)
                $this->addComposerDestination ($compdest, $countryCode);
        }
        
        protected function addComposerDestination($compDest, $countryCode = null){
            $messageId = $compDest->getMessageId();
            
            if (!is_null($messageId) && !empty($messageId)){
                // message Id must not already exist
                if (array_key_exists($messageId, $this->_messageIdsMap))
                    throw new \Exception("Message identifier '{$messageId}' already exists.");
                    
                // add to the message Ids map
                $this->_messageIdsMap[$messageId] = $compDest;
            }
            
            // attach to the destinations collection
            $this->_destinations->attach($compDest);
            
            // get the phone number
            $phoneNumber = $compDest->getPhoneNumber();
            
            if (array_key_exists($phoneNumber, $this->_destinationsKeyMap)){
                $compDestStore = $this->getMappedDestinations($phoneNumber);
                $compDestStore->attach($compDest);
            }
            else {
                $destList = new ObjectStorage();
                $destList->attach($compDest);
                
                $infoContainer[self::__DEST_COUNTRYCODE_LABEL__] = $countryCode;
                $infoContainer[self::__DEST_COMP_LIST_LABEL__] = $destList;
                
                $this->_destinationsKeyMap[$phoneNumber] = $infoContainer;
            }
        }
        
        protected function createComposerDestination($phoneNumber, $messageId, $destMode, $destData, $isScheduled = false){     
            // create and set key data mappings
            $compDestData = array();
            $compDestData['phoneNumber'] = $phoneNumber;
            $compDestData['messageId'] = $messageId;
            $compDestData['destMode'] = $destMode;
            $compDestData['destData'] = $destData;
            $compDestData['scheduled'] = $isScheduled;
            
            return ComposerDestination::create($compDestData);
        }

        public function messageIdExists($messageId){
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid reference for verifying message identifier.');
            
            return array_key_exists($messageId, $this->_messageIdsMap);
        }
        
        protected function removeComposerDestinationsList($phoneNumber, $compDestStore){
            $replaceList = array();
            $countryCode = $this->getDestinationCountryCode($phoneNumber);
            
            if (count($compDestStore) > 0){
                $compDestArr = &$compDestStore->getItems();
 
                for ($i = 0; $i < count($compDestArr); $i++){
                    $compDest = $compDestArr[$i];
                    
                    if ($compDest->isScheduled()){
                        $destination = $compDest->getPhoneNumber();
                        $messageId = $compDest->getMessageId();
                        $mode = DestinationMode::DM_DELETE;
                        $data = $compDest->getData();
                        
                        // create new for replacement
                        $newCompDest = $this->createComposerDestination($destination, $messageId, $mode, $data, true);
                        $replaceList[] = $newCompDest;
                    }
                    
                    // remove
                    $this->removeComposerDestination($compDest);
                }
                
                // the array is not needed
                unset($compDestArr);
                
                // if there are any to replace (scheduled destinations), add them
                if (count($replaceList) > 0)
                    $this->addComposerDestinationsList ($replaceList, $countryCode);
            }
        }
        
        protected function removeComposerDestination($compDest){
            if (is_null($compDest) || $compDest instanceof ComposerDestination == false)
                throw new \Exception('Invalid object reference for removing message composer destination.');
            
            if ($this->_destinations->contains($compDest)){
                // If there is a message Id, disassociate it
                $messageId = $compDest->getMessageId();
                $phoneNumber = $compDest->getPhoneNumber();
                
                // If there is a message Id, remove it
                if (!is_null($messageId) && array_key_exists($messageId, $this->_messageIdsMap))
                    unset($this->_messageIdsMap[$messageId]);
                
                // Remove it from destinations mapped by this phone number
                $mappedDests = $this->getMappedDestinations($phoneNumber);
                $mappedDests->detach($compDest);
                
                // If there is no item in destinations mapped by the phone number,
                // then the phone number serving as a key should be removed
                if ($mappedDests->getCount() == 0)
                    unset($this->_destinationsKeyMap[$phoneNumber]);
 
                // remove it from the composer destinations collection
                $this->_destinations->detach($compDest);
                
                // return success
                return true;
            }
            
            return false;
        }

        public function removeDestination($phoneNumber) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for removing message destination.');
            
            // destination should exist
            if (!$this->destinationExists($phoneNumber))
                return false;
            
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            $compDestStore = $this->getMappedDestinations($fmtdNumber);
            $this->removeComposerDestinationsList($fmtdNumber, $compDestStore);
            
            return true;
        }
        
        public function removeDestinationById($messageId) {
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid message identifier for removing destination.');
            
            // it must exist
            if (!$this->messageIdExists($messageId))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
            
            // get the destination for removal
            $compDest = $this->getComposerDestinationById($messageId);
            
            // remove the destination
            return $this->removeDestination($compDest);
        }
        
        protected function getPhoneNumberFromMessageId($messageId){
            // validate message Id
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid message identifier for getting destination.');
            
            // it should exist
            if (!array_key_exists($messageId, $this->_messageIdsMap))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            // get the mapped composer destination
            $compDest = $this->_messageIdsMap[$messageId];
           
            // return phone number
            return $compDest->getPhoneNumber();
        }
        
        protected function validateCustomMessageId($messageId, $throwEx){
            if (!is_null($messageId) && !empty($messageId)){
                // It should not exist in the message Ids list
                if (array_key_exists($messageId, $this->_messageIdsMap)) {
                    if (!$throwEx)
                        return NumberAddInfo::NAI_REJTD_MSGID_EXISTS;
                    
                    // exception should be thrown
                    throw new \Exception("Message identifier '{$messageId}' already exists.");
                }
                
                // check length is accepted
                $len = strlen($messageId);
                
                if ($len < MessageUtil::__CUSTOM_MSGID_MIN_LEN__ || $len > MessageUtil::__CUSTOM_MSGID_MAX_LEN__) {
                    if (!$throwEx)
                        return NumberAddInfo::NAI_REJTD_MSGID_LENGTH;
                    
                    throw new \Exception('Invalid message identifier length.');
                }
                
                // should match allowed pattern
                $pattern = "/[A-Za-z0-9-]{".MessageUtil::__CUSTOM_MSGID_MIN_LEN__.",}/";
                
                if (!preg_match($pattern, $messageId)){
                    if (!$throwEx)
                        return NumberAddInfo::NAI_REJTD_MSGID_INVALID;
                    
                    throw new \Exception("Message identifier '{$messageId}' is not in the correct format.");
                }
            }
            
            return NumberAddInfo::NAI_OK;
        }
        
        protected function validateDestinationUpdate($prePhoneNumber, $newPhoneNumber){
            if (is_null($prePhoneNumber) || empty($prePhoneNumber))
                throw new \Exception('Invalid reference to previous phone number for updating destination.');
            
            if (is_null($newPhoneNumber) || empty($newPhoneNumber))
                throw new \Exception('Invalid reference to new phone number for updating destination.');
            
            // convert to international number formats
            $preNumberInfo = $this->formatPhoneNumber($prePhoneNumber);
            $newNumberInfo = $this->formatPhoneNumber($newPhoneNumber);
            
            if (is_null($preNumberInfo))
                throw new \Exception('Invalid or unsupported previous phone number for updating destination.');
            
            if (is_null($newNumberInfo))
                throw new \Exception('Invalid or unsupported new phone number for updating destination.');
            
            return array('pre'=>$preNumberInfo, 'new'=>$newNumberInfo);
        }
        
        protected function updateComposerDestination($compDest, $newPhoneNumber) {
            $numInfo = $this->formatPhoneNumber($newPhoneNumber);
            $countryCode = $numInfo[1];
            
            $destData = $compDest->getData();
            $messageId = $compDest->getMessageId();
            $scheduled = $compDest->isScheduled();
            $destMode  = $scheduled ? DestinationMode::DM_UPDATE : $compDest->getWriteMode(); // update if scheduled
            
            // create new composer destination
            $newCompDest = $this->createComposerDestination($newPhoneNumber, $messageId, $destMode, $destData, $scheduled);
            
            // unlink previous one before adding new one
            if ($this->removeComposerDestination($compDest)){
                $this->addComposerDestination($newCompDest, $countryCode);
                return true;
            }
            
            return false;
        }
        
        public function updateDestination($prePhoneNumber, $newPhoneNumber) {
            // perform validation
            $numbersInfoData = $this->validateDestinationUpdate($prePhoneNumber, $newPhoneNumber);
            
            // get formatted phone numbers and country code
            $preFmtdNumber = $numbersInfoData['pre'][0];
            $compDestsStore = $this->getMappedDestinations($preFmtdNumber);
            
            // we will iterate and update composer destinations associated with the phone number
            if (!is_null($compDestsStore) && $compDestsStore->getCount() > 0){
                $compDestsArr = &$compDestsStore->getItems();
                
                foreach ($compDestsArr as $compDest){
                    $this->updateComposerDestination($compDest, $newPhoneNumber);
                }
                
                return true;
            }
            
            return false;
        }
        
        public function updateDestinationById($messageId, $newPhoneNumber) {
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid message identifier for updating destination.');
            
            if (!$this->messageIdExists($messageId))
                throw new \Exception("Message identifier '{0}' does not exist.");
            
            if (is_null($newPhoneNumber) || !PhoneUtil::isValidPhoneNumber($newPhoneNumber))
                throw new \Exception('Invalid phone number for updating destination.');
            
            // get the previous phone number and use it for the update
            $compDest = $this->getComposerDestinationById($messageId);
            
            // update to the new phone number
            return $this->updateComposerDestination($compDest, $newPhoneNumber);
        }

        public function getDestinations() {
            // create new composer destinations list for iteration
            $destValues = &$this->_destinations->getItems();
            
            // create an iterable list of the items
            return new ComposerDestinationsList($destValues);
        }
        
        public function getDestinationsCount(){
            return $this->_destinations->getCount();
        }
        
        public function setDefaultNumberPrefix($dialCode) {
            if (is_null($this->_userData))
                throw new \Exception('Authentication request has not been performed.');
            
            $this->_userData->setDefaultNumberPrefix($dialCode);
        }
        
        public function getDefaultNumberPrefix() {
            return $this->_userData == null ? null : $this->_userData->getDefaultNumberPrefix();
        }
        
        public function getRouteCountries() {
            if (is_null($this->_userData))
                return null;
            
            return $this->_userData->getRouteCountries();
        }
        
        protected function isRoutesPhoneNumber($phonenum){
            if (is_null($this->_userData))
                throw new \Exception('Routes data have not been loaded.');
            
            $numberInfo = $this->formatPhoneNumber($phonenum);
            return !is_null($numberInfo);
        }
        
        public function notifyDeliveries(){
            return !(is_null($this->_notifyURL) && empty($this->_notifyURL));
        }
        
        public function getNotifyURLInfo() {
            return array($this->_notifyURL, $this->_notifyContentType);
        }

        public function getDefaultTimeZone() {
            if (is_null($this->_userData))
                return null;
            
            return $this->_userData->getDefaultTimeZone();
        } 
    }