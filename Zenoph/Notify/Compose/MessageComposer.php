<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Compose;
    
    use Zenoph\Notify\Compose\Schedule;
    use Zenoph\Notify\Utils\PhoneUtil;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Enums\DestinationMode;
    use Zenoph\Notify\Build\Reader\MessageDestinationsReader;
    
    
    abstract class MessageComposer extends Composer implements IMessageComposer, ISchedule {
        protected $_sender;
        protected $_scheduler;
        protected $_templateId;
        protected $_isScheduled;
        
        public function __construct($authProfile = null) {
            parent::__construct($authProfile);
            
            // initialise scheduler
            $this->_scheduler = new Schedule();
            $this->_isScheduled = false;
            $this->_templateId = null;
            $this->_sender = null;
        }
        
        public function setSender($sender){
            if (is_null($sender) || empty($sender))
                throw new \Exception('Missing or invalid message sender identifier.');
            
            $this->_sender = $sender;
        }
        
        public function getSender(){
            return $this->_sender;
        }
        
        public function getTemplateId() {
            return $this->_templateId;
        }
        
        public function getReferenceId() {
            return $this->getTemplateId();
        }
        
        public function getScheduleInfo() {
            return array(
                $this->_scheduler->getDateTime(),
                $this->_scheduler->getDateTime()
            );
        }
        
        public function isScheduled() {
            return $this->_isScheduled;
        }
        
        public function schedule() {
            return !(is_null($this->_scheduleDateTime) && empty($this->_scheduleDateTime));
        }
        
        protected function createComposerDestination($phoneNumber, $messageId, $destMode, $destData, $isScheduled = false){
            // For scheduled messages that have been loaded, we will automatically assign
            // a message Id if client does not provide one
            if ($this->isScheduled() && (is_null($messageId) || empty($messageId))){
                // generate and sssign a message id automatically
                $messageId = $this->generateMessageId();
            }

            return parent::createComposerDestination($phoneNumber, $messageId, $destMode, $destData, $isScheduled);
        }
        
        private function generateMessageId(){
            $messageId = null;
            $exists = false;
            
            do {
                $messageId = $this->generateUUID();
                $exists = array_key_exists($messageId, $this->_messageIdsMap);
            } while ($exists);
            
            // return the message Id
            return $messageId;
        }
        
        private function generateUUID(){
            return function_exists('openssl_random_pseudo_bytes') ? 
                $this->generateOpenSSLUUID() : 
                $this->generateMTRandUUID();
        }
        
        private function generateOpenSSLUUID(){
            $randomBytes = (bin2hex(openssl_random_pseudo_bytes(16)));
            
            // we want them in smaller letter casing
            $randomBytes = strtolower($randomBytes);

            $hyphen = chr(45);// "-"
            $UUID = ""
                .substr($randomBytes, 0, 8).$hyphen
                .substr($randomBytes, 8, 4).$hyphen
                .substr($randomBytes,12, 4).$hyphen
                .substr($randomBytes,16, 4).$hyphen
                .substr($randomBytes,20,12);
            
            // return generated UUID
            return $UUID;
        }
        
        private function generateMTRandUUID() {
            // Credit to William: https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff ), mt_rand(0, 0xffff ),

                // 16 bits for "time_mid"
                mt_rand(0, 0xffff ),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff ) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff ) | 0x8000,

                // 48 bits for "node"
                mt_rand(0, 0xffff ), mt_rand(0, 0xffff ), mt_rand(0, 0xffff )
            );
        }
        
        public static function populateScheduledDestinations($mc, &$data){
            if (is_null($mc) || $mc instanceof Composer == false)
                throw new \Exception('Invalid reference to Message object for populating destinations.');
            
            // the message should be a personalised one
            if (!$mc->isScheduled())
                throw new \Exception('Message has not been scheduled for populating scheduled destinations.');
            
            if (is_null($data) || empty($data))
                throw new \Exception('Invalid reference to data fragment for populating message destinations.');
            
            // clear any existing destinations
            $mc->clearDestinations();
            
            // read and return destinations count
            return self::readScheduledDestinations($mc, $data);
        }
        
        private static function readScheduledDestinations($mc, &$data){
            // initialise reader
            $reader = new MessageDestinationsReader();
            $reader->setData($data);
            
            $md = null;
            $destsCount = 0;
            
            while (($md = $reader->getNextItem()) != null){
                $phoneNumber = $md->getPhoneNumber();
                $messageId   = $md->getMessageId();
                $destData    = $md->getData();
                $destMode    = DestinationMode::DM_NONE;
                $scheduled   = true;
                
                // create composer destination
                $compDest = $mc->createComposerDestination($phoneNumber, $messageId, $destMode, $destData, $scheduled);
                
                // country code will be needed
                $countryCode = null;
                $numberInfo = $mc->formatPhoneNumber($phoneNumber);
                
                if (!is_null($numberInfo))
                    $countryCode = $numberInfo[1];
                
                // add to destinations and increment count
                $mc->addComposerDestination($compDest, $countryCode);
                $destsCount++;
            }
            
            // return count of destinations that were populated
            return $destsCount;
        }
        
        public function setScheduleDateTime($dateTime, $val1 = null, $val2 = null) {
            $this->_scheduler->setScheduleDateTime($dateTime, $val1, $val2);
        }
        
        private function removeMessageDestination($md){
            if (is_null($md) || $md instanceof MessageDestination === false)
                throw new \Exception('Invalid object reference for removing destination.');
            
            // only messages that are scheduled and loaded are allowed here
            if (!$this->isScheduled())
                throw new \Exception('Message destination objects can only be removed from loaded scheduled messages.');
            
            // get the messageId
            $messageId = $md->getMessageId();
            
            if ($this->messageIdExists($messageId)){
                // get the corresponding composer destination for removal
                $compDest = $this->getComposerDestinationById($messageId);
                
                if (!is_null($compDest))
                    return $this->removeComposerDestination($compDest);
            }
        }
        
        public function removeDestinationById($messageId) {
            if (!$this->isScheduled())
                return parent::removeDestinationById ($messageId);
            
            if ($this->messageIdExists($messageId)){
                $compDest = $this->getComposerDestinationById($messageId);
                $tempCompDest = null;

                // Though message is scheduled, it's possible for destination to be non-scheduled
                // if it was newly added after scheduled message was loaded.
                if ($compDest->isScheduled()){
                    $destMode = DestinationMode::DM_DELETE;
                    $tempCompDest = $this->createComposerDestination(null, $messageId, $destMode, null, true);
                }
                
                // remove destination
                $this->removeComposerDestination($compDest);
                
                // if scheduled destination to be removed, tempCd will not be null
                if (!is_null($tempCompDest))
                    $this->addComposerDestination($tempCompDest);
                
                // return success
                return true;
            }
            
            return false;
        }
        
        public function updateDestinationById($messageId, $phoneNumber) {
            if (!$this->isScheduled())
                return parent::updateDestinationById($messageId, $phoneNumber);
            
            if (is_null($phoneNumber) || !PhoneUtil::isValidPhoneNumber($phoneNumber))
                throw new \Exception('Invalid phone number for updating message destination.');
            
            $numInfo = $this->formatPhoneNumber($phoneNumber, true);
            $fmtdNumber = $numInfo[0];
            $countryCode = $numInfo[1];
            
            // message identifier should exist
            if ($this->messageIdExists($messageId)){
                $compDest = $this->getComposerDestinationById($messageId);
                return $this->updateComposerDestination($compDest, $phoneNumber);
            }
            else {
                $destMode = DestinationMode::DM_UPDATE;
                $compDest = $this->createComposerDestination($fmtdNumber, $messageId, $destMode, null, true);
                
                // add for update
                $this->addComposerDestination($compDest, $countryCode);
                return true;
            }
        }
        
        public function refreshScheduledDestinationsUpdate($destsList){
            if (is_null($destsList))
                throw new \Exception('Invalid object reference to message destinations collection.');
            
            // only scheduled messages that have been loaded are allowed to do this
            if (!$this->isScheduled())
                throw new \Exception('The message has not been scheduled for refreshing updated destinations.');
            
            foreach ($destsList as $msgDest){
                if ($msgDest->getStatus() == DestinationStatus::DS_SCHEDULE_DELETED)
                    $this->removeMessageDestination ($msgDest);
                else 
                    $this->resetScheduledDestination ($msgDest->getMessageId());
            }
        }
        
        private function resetScheduledDestination($messageId){
            // the message Id should exist
            if (!array_key_exists($messageId, $this->_messageIdsMap))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            $preCompDest = $this->getComposerDestinationById($messageId);
            
            // Can't change write mode directly. we will need to create a new one for replacement
            $phoneNumber = $preCompDest->getPhoneNumber();
            $destData = $preCompDest->getData();
            $destMode = DestinationMode::DM_NONE;
            
            // create the composer destination
            $newCompDest = $this->createComposerDestination($phoneNumber, $messageId, $destMode, $destData, true);
            
            // we will need country code
            $countryCode = null;
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            
            if (!is_null($numberInfo))
                $countryCode = $numberInfo[1];
            
            // remove previous and add new one with updated write mode
            $this->removeComposerDestination($preCompDest);
            $this->addComposerDestination($newCompDest, $countryCode);
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
            
            // If not loaded scheduled message, check for duplicates
            if (!$this->isScheduled()){
                // previous number should exist in destinations
                if (!$this->formattedDestinationExists($preNumberInfo[0]))
                    throw new \Exception("Phone number '{$preNumberInfo[0]}' does not exist in the destinations list.");
                    
                // the new number should not already exist
                if ($this->formattedDestinationExists($newNumberInfo[0]))
                    throw new \Exception("Phone number '{$newNumberInfo[0]}' already exists in the destinations list.");
            }
            
            return array('pre'=>$preNumberInfo, 'new'=>$newNumberInfo);
        }
        
        public function validateDestinationSenderName($phoneNumber) {
            // the phone number must exist to continue
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            
            if (is_null($numberInfo))
                return null;
            
            // formatted number
            $fmtdNumber = $numberInfo[0];
            
            if (!array_key_exists($fmtdNumber, $this->_destinationsKeyMap) || is_null($this->_userData))
                return;
          
            $countryCode = $this->_destinationsKeyMap[$fmtdNumber]['countryCode'];
            
            // find out if the country requires sender registration or not.
            $routeFilters = $this->_userData->getRouteFilters();
            
            if (array_key_exists($countryCode, $routeFilters)){
                $countryName = $routeFilters[$countryCode]['countryName'];
                
                if ($routeFilters[$countryCode]['registerSender']){
                    $this->checkSenderRegistration($countryCode, $countryName);
                }
                
                // see if numeric sender is allowed
                if (MessageUtil::isNumericSender($this->_sender) && !$routeFilters[$countryCode]['numericSenderAllowed']){
                    throw new \Exception("Numeric message sender are not allowed in sending messages to '{$countryName}'.");
                }
            }
        }
        
        private function checkSenderRegistration($countryCode, $countryName){
            // get message senders
            $messageSenders = $this->_userData->getMessageSenders();
            $category = MessageUtil::getMessageCategoryLabel($this->_category);
            $senderMatched = false;
            
            if (is_null($messageSenders) || !isset($messageSenders[$category]))
                throw new \Exception("Message sender name '{$this->_sender}' is not permitted ".
                    "for sending messages to {$countryName}. Please make a request from your account.");
                
            foreach ($messageSenders[$category] as $senderName=>$senderInfo){
                $caseSensitive = $senderInfo['sensitive'];
                $senderCountryCodes = $senderInfo['countryCodes'];
                
                // see if there is a match, then we check country codes
                if ($this->isMessageSenderMatch($senderName, $caseSensitive)) {
                    // See if the sender ID is permitted in the specified country
                    if (!$this->senderCountryCodeExists($senderCountryCodes, $countryCode))
                        continue;
                    
                    // we found match
                    $senderMatched = true;
                    break;
                }
            }

            if (!$senderMatched)
                throw new \Exception("Message sender '{$this->_sender}' is not permitted for sending messages to {$countryName}");
        }
        
        private function senderCountryCodeExists(&$countryCodes, $testCode){
            foreach ($countryCodes as $code){
                if (strtolower($testCode) === strtolower($code))
                    return true;
            }
            
            // not found
            return false;
        }
        
        private function isMessageSenderMatch($testSender, $caseSensitive){
            if ($caseSensitive)
                return $this->_sender === $testSender;
            
            // not case sensitive
            return strtolower($this->_sender) === strtolower($testSender);
        }
    }