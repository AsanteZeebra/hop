<?php

    namespace Zenoph\Notify\Compose;
    
    use Zenoph\Notify\Utils\PhoneUtil;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Enums\DestinationMode;
    use Zenoph\Notify\Enums\MessageCategory;
    use Zenoph\Notify\Enums\TextMessageType;
    use Zenoph\Notify\Enums\NumberAddInfo;
    use Zenoph\Notify\Store\AuthProfile;
    use Zenoph\Notify\Store\PersonalisedValues;
    use Zenoph\Notify\Collections\PersonalisedValuesList;

    class SMSComposer extends MessageComposer implements ISMSComposer {
        private $_wpushURL;
        private $_isPsnd;
        private $_type;
        private static $varsPattern = "/\{\\$[a-zA-Z_][a-zA-Z0-9]+\}/";
        
        const NUMERIC_SENDER_MAX_LEN = 18;
        const ALPHA_NUMERIC_SENDER_MAX_LEN = 11;
        
        public function __construct($ap = null) {
            parent::__construct($ap);
            $this->_type = TextMessageType::TEXT;
            $this->_category = MessageCategory::MC_SMS;
            
            if (!is_null($ap) && $ap instanceof AuthProfile){
                $this->_type = $ap->getUserData()->getDefaultTextMessageType();
            }
        }
        
        public static function create($data){
            if (is_null($data) || !is_array($data))
                throw new \Exception('Invalid data for initialising text message composer.');
            
            $authProfile = null;
            $templateId = null;
            $isScheduled = false;
            
            if (array_key_exists('authProfile', $data)){
                // It should not be null or once it has been set.
                $authProfile = $data['authProfile'];

                if (is_null($authProfile) || $authProfile instanceof AuthProfile == false)
                    throw new \Exception("Invalid reference to authentication profile for initialising message object.");
            }

            // check message id.
            if (array_key_exists('templateId', $data)){
                $templateId = $data['templateId'];

                // it shouldn't be null or empty once it has been set
                if (is_null($templateId) || empty($templateId))
                    throw new \Exception("Invalid message identifier for initialising message object.");

                // there should be category specifier
                if (!array_key_exists('category', $data))
                    throw new \Exception("Missing message category specifier for initialising message object.");
            }
            
            // If the message was scheduled and has been loaded
            if (array_key_exists('scheduled', $data))
                $isScheduled = (bool)$data['scheduled'];
            
            // create TextMessage object
            $tm = is_null($authProfile) ? new SMSComposer() : new SMSComposer($authProfile);
            
            if (!is_null($templateId) && !empty($templateId)) {
                $tm->_templateId = $templateId;
                $tm->_category = $data['category'];
            }
            
            // schedule state
            $tm->_isScheduled = $isScheduled;
            
            // return composer
            return $tm;
        }
        
        public static function getMessageCount($message, $type){
            if (is_null($message) || empty($message))
                return 0;
            
            if (is_null($type) || !TextMessageType::isDefined($type))
                throw new \Exception('Invalid message type specifier for determining message count.');
            
            $typeInfo = MessageUtil::getMessageTypeInfo($type);
            
            // If null, then user serttings have not been loaded
            if (is_null($typeInfo))
                return -1;
            
            // determination of message count
            $singlePageLen = $typeInfo['singleLen'];
            $concatPageLen = $typeInfo['concatLen'];
            $messageLen = strlen($message);
            $remLen = $messageLen;
            $messageCount = 1;
            
            while ($remLen > $singlePageLen){
                $messageCount += 1;
                $remLen -= $concatPageLen;
            }
    
            return $messageCount;
        }

        public static function getMessageVariablesCount($messageText){
            if (is_null($messageText) || empty($messageText))
                return 0;
            
            return count(self::getMessageVariables($messageText));
        }
        
        public static function getMessageVariables($messageText, $trim = true){
            $vars = array(); 
            $varsList = array();
            
            if (!is_null($messageText) && !empty($messageText)) {
                preg_match_all(self::$varsPattern, $messageText, $vars, PREG_SET_ORDER);        

                foreach ($vars as $var){
                    $tempVar = $var[0];

                    if ($trim === true)
                        $tempVar = self::trimVariable ($tempVar);

                    $varsList[] = $tempVar;
                }
            }
            
            return $varsList;
        }
        
        private static function trimVariable($variable){
            // define pattern for trimming
            $pattern = "/[\{\}\$]/";
            
            // trim
            return preg_replace($pattern, '', $variable);
        }
        
        public function getRegisteredSenderIds() {
            if (is_null($this->_userData))
                return null;
            
            $senderIdsInfo = &$this->_userData->getMessageSenders();
        }
  
        public function isPersonalised() {
            return $this->_isPsnd;
        }
        
        private function assertPersonalisedValues($phoneNumber, &$values, $throwEx){
            if (is_null($values) || !is_array($values) || count($values) == 0) {
                if ($throwEx === false)
                    return NumberAddInfo::NAI_REJTD_VALUES_EMPTY;
                
                throw new \Exception('Invalid reference to personalised values.');
            }
            
            // the message text should have already been set.
            if (is_null($this->_message) || empty($this->_message)) {
                // here we will throw exception irrespective of $throwEx
                throw new \Exception('Message text has not been set for validating personalised values.');
            }
            
            $varsList = self::getMessageVariables($this->_message);
            
            if (is_null($varsList) || count($varsList) != count($values)){
                if ($throwEx === false)
                    return NumberAddInfo::NAI_REJTD_VALUES_COUNT;

                throw new \Exception('Mismatch variables and values count.');
            }

            // all values must be provided
            for ($i = 0; $i < count($values); ++$i){
                $val = $values[$i];

                if (is_null($val)){
                    if ($throwEx === false)
                        return NumberAddInfo::NAI_REJTD_VALUES_MISVAL;

                    $pos = $i + 1;
                    throw new \Exception("Invalid personalised value at position '{$pos}' for phone number '{$phoneNumber}'.");
                }
            }
            
            return NumberAddInfo::NAI_OK;
        }
        
        public function addPersonalisedDestination($phoneNumber, $throwEx, $values, $messageId = null) {
            if (is_null($phoneNumber) || empty($phoneNumber) || !PhoneUtil::isValidPhoneNumber($phoneNumber)){
                if ($throwEx === false)
                    return NumberAddInfo::NAI_REJTD_INVALID;
                
                // Exception can be thrown
                throw new \Exception('Invalid phone number for adding personalised message values.');
            }
           
            // the message should be set for personalising
            if (!$this->isPersonalised()) {
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_NON_PSND;
                
                throw new \Exception('Message is not personalised to add values.');
            }
            
            $numberAddInfo = null;
            
            // If message Id is provided, it should be validated
            if (!is_null($messageId) && !empty($messageId)){
                $numberAddInfo = $this->validateCustomMessageId($messageId, $throwEx);
                
                if ($numberAddInfo != NumberAddInfo::NAI_OK)
                    return $numberAddInfo;
            }
            
            // also validate the personalised values
            $numberAddInfo = $this->assertPersonalisedValues($phoneNumber, $values, $throwEx);
            
            if ($numberAddInfo != NumberAddInfo::NAI_OK)
                return $numberAddInfo;
            
            // format phone number
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            
            if (is_null($numberInfo)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_ROUTE;
                
                throw new \Exception("Phone number '{$phoneNumber}' is invalid or ".
                    "not allowed on registered routes.");
            }
            
            $fmtdNumber = $numberInfo[0];
            $countryCode = $numberInfo[1];
            $valuesContainer = $this->getDestinationPersonalisedValues($fmtdNumber);
            
            // We will not allow same values for same destination
            if (!is_null($valuesContainer) && $this->valuesExist($valuesContainer, $values)){
                if (!$throwEx)
                    return NumberAddInfo::NAI_REJTD_VALUES_EXIST;
                
                throw new \Exception("The personalised values already exist for destination '{$fmtdNumber}'.");
            }
            
            $pv = new PersonalisedValues($values);
            return $this->addDestinationInfo($fmtdNumber, $countryCode, $messageId, $pv);
        }
        
        public function getPersonalisedMessageId($phoneNumber, &$values) {
            if (!$this->isPersonalised()){
                return parent::getMessageId($phoneNumber);
            }
            else {
                // values must be provided
                if (is_null($values) || !is_array($values) || count($values) == 0)
                    throw new \Exception("Invalid reference to values list for custom message identifier.");
                
                # get the composer destinations list
                $compDestsList = $this->getMappedDestinations($this->getFormattedPhoneNumber($phoneNumber));
                
                foreach ($compDestsList as $destInfo){
                    $pv = $destInfo->getData();
                    
                    if (join(",", $pv->export()) == join(",", $values)){
                        return $destInfo->getMessageId();
                    }
                }
                
                // not found
                throw new \Exception("The specified personalised values were not found.");
            }
        }
        
        public function addDestination($phoneNumber, $throwEx = true, $messageId = null) {
            if (!is_null($this->_message) && !empty($this->_message)){
                if (self::getMessageVariablesCount($this->_message) > 0 && $this->isPersonalised()){
                    if (!$throwEx)
                        return NumberAddInfo::NAI_REJTD_VALUES_EMPTY;
                    
                    throw new \Exception('Missing personalised values for destination.');
                }
            }
            
            return parent::addDestination($phoneNumber, $throwEx, $messageId);
        }
        
        private function valuesExist($pvList, &$values){
            if (!is_null($pvList)){
                
                foreach ($pvList as $pv){
                    if (join(',', $pv->export()) == join(',', $values))
                        return true;
                }
            }
            
            // not found
            return false;
        }
        
        public function personalisedValuesExists($phoneNumber, $values) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for verifying personalised values.');
            
            // destination should already exist
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist in the destinations list.");
                
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            // assert personalised values
            $this->assertPersonalisedValues($fmtdNumber, $values, true); 
            $valuesList = $this->getPersonalisedValues($fmtdNumber);
            
            return $this->valuesExist($valuesList, $values);
        }
        
        public function removePersonalisedDestination($phoneNumber, $values) {
            if (is_null($phoneNumber) || !is_string($phoneNumber) || empty($phoneNumber))
                throw new \Exception("Invalid phone number for removing message destination.");
            
            if (is_null($values) || !is_array($values) || count($values) == 0)
                throw new \Exception("Invalid personalised values for removing message destination.");
            
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist.");
                
            // we will need the formatted phone number to obtain the composer destination object
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            // get the composer destination objects that this phone number maps to
            $compDestsList = $this->getMappedDestinations($fmtdNumber);
            
            foreach ($compDestsList as $compDest){
                $psndValues = $compDest->getData();
                
                if (join(",", $psndValues->export()) == join(",", $values)){
                    return $this->removeComposerDestination($compDest);
                }
            }
            
            return false;
        }

        public function removePersonalisedValues($phoneNumber, $values) {
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid reference to phone number for removing personalised values.');
            
            if (is_null($values) || !is_array($values))
                throw new \Exception('Invalid reference to data for removing personalised values.');
            
            if (count($values) == 0)
                throw new \Exception('No personalised messages have been provided to be removed.');
            
            // Ensure the destination exists before continuing.
            if (!$this->destinationExists($phoneNumber))
                return false;
            
            // message should be set as personalised
            if (!$this->isPersonalised())
                throw new \Exception('Message has not been personalised for removing values.');
            
            // Get the personalised values for the destination. If such values
            // exist, they will have to be deleted
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            $compDestsStore = $this->getMappedDestinations($fmtdNumber);
            $countryCode = $this->getDestinationCountryCode($fmtdNumber);
            
            // If there is only set of values, we will not allow delete on it 
            // since it will leave the destination with no personalised values.
            if ($compDestsStore->getCount() <= 1)
                throw new \Exception('Cannot remove personalised values for destination with one container dimension.');
            
            // get the destinations as array
            $compDestsArr = &$compDestsStore->getItems();
            
            // search through for the values.
            foreach ($compDestsArr as $compDest){
                $currPv = $compDest->getData();

                if (join(',', $currPv->export()) === join(',', $values)){
                    // In the case of scheduled destination, we will need a replacement
                    // since we can't modify the write mode directly
                    $replaceCompDest = null;
                    
                    if ($compDest->isScheduled()){
                        $destMode = DestinationMode::DM_DELETE;
                        $messageId = $compDest->getMessageId();
                        $replaceCompDest = $this->createComposerDestination($phoneNumber, $messageId, $destMode, $currPv, true);
                    }
                    
                    // remove
                    $this->removeComposerDestination($compDest);
                    
                    // If there should be replacement, add it
                    if (!is_null($replaceCompDest))
                        $this->addComposerDestination ($compDest, $countryCode);
                    
                    return true;
                }
            }
            
            return false;
        }
        
        public function getDefaultMessageType() {
            if (is_null($this->_userData))
                return null;
            
            return $this->_userData->getDefaultTextMessageType();
        }
        
        public function getPersonalisedDestinationWriteMode($phoneNumber, $values) {
            // the message should be personalised
            if (!$this->isPersonalised())
                throw new \Exception('Message is not personalised for getting personalised destination mode.');
            
            // destination should already exist
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist in the destinations list.");
                
            // get the formatted number
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            // get the composer destinations values and iterate for the specified values
            $compDestsStore = $this->getMappedDestinations($fmtdNumber);
            $compDestsArr = &$compDestsStore->getItems();
            
            foreach ($compDestsArr as $compDest){
                $pv = $compDest->getData();
                
                if (join(',', $pv->export()) === join(',', $values))
                    return $compDest->getWriteMode();
            }
            
            // at this point we could find one with the specified values
            throw new \Exception('The specified personalised values were not found for the destination.');
        }
      
        public function getPersonalisedDestinationMessageId($phoneNumber, $values) {
            // message should be personalised
            if (!$this->isPersonalised())
                throw new \Exception('Message is not personalised for getting destination message identifier.');
            
            if (is_null($values) || !is_array($values) || count($values) == 0)
                throw new \Exception('Invalid values for getting destination message identifier.');
            
            // get the composer destinations and iterate for the specified values
            $fmtdPhoneNumber = $this->getFormattedPhoneNumber($phoneNumber);
            $compDestsStore = $this->getMappedDestinations($fmtdPhoneNumber);
            $compDestsArr = &$compDestsStore->getItems();
            
            foreach ($compDestsArr as $compDest){
                $pv = $compDest->getData();
                
                if (join(',', $pv->export()) === join(',', $values))
                    return $compDest->getMessageId();
            }
            
            // we did not find it
            throw new \Exception("Invalid values for getting destination message identifier.");
        }
        
        private function getDestinationPersonalisedValues($phoneNumber){
            if ($this->formattedDestinationExists($phoneNumber)) {
                $compDestsStore = $this->getMappedDestinations($phoneNumber);
                $compDestsArr = &$compDestsStore->getItems();
                $pvList = new PersonalisedValuesList();

                foreach ($compDestsArr as $compDest){
                    // get the personalised values object
                    $pv = $compDest->getData();

                    // add to the list
                    $pvList->addItem($pv);
                }

                // return the list
                return $pvList;
            }
            
            return null;
        }
        
        public function getPersonalisedValues($phoneNumber){
            // message should be personalised and destination must exist
            if (!$this->isPersonalised())
                throw new \Exception('Message is not personalised for getting destination personalised values.');
            
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist for getting personalised values.");
            
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            return $this->getDestinationPersonalisedValues($fmtdNumber);
        }
        
        public function getPersonalisedValuesById($messageId) {
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid message identifier for getting personalised values.');
            
            // it should exist
            if (!$this->messageIdExists($messageId))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            // get the composer destination object and obtain the personalised values
            $compDest = $this->getComposerDestinationById($messageId);
            $pv = $compDest->getData();
            
            // We should return the string array and not object itsel
            if (!is_null($pv))
                return $pv->export();
            
            // nothing to return
            return null;
        }
        
        private function validatePersonalisedValuesForUpdate($phoneNumber, $newValues, $prevValues = null){
            if (is_null($phoneNumber) || empty($phoneNumber))
                throw new \Exception('Invalid phone number for updating personalised values.');
            
            // message should be a personalised one
            if (!$this->isPersonalised())
                throw new \Exception('Message is not being personalised for updating values.');
            
            // the destination should exist
            if (!$this->destinationExists($phoneNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist in the destinations list.");
                
            // assert new values, and previous values if provided
            $this->assertPersonalisedValues($phoneNumber, $newValues, true); 
            
            if (!is_null($prevValues) && is_array($prevValues))
                $this->assertPersonalisedValues ($phoneNumber, $prevValues, true);
        }
        
        public function updatePersonalisedValuesById($messageId, $newValues){
            if (is_null($messageId) || empty($messageId))
                throw new \Exception("Invalid message identifier for updating personalised values.");
            
            // it should exist
            if (!$this->messageIdExists($messageId))
                throw new \Exception("Message identifier '{$messageId}' does not exist.");
                
            $compDest = $this->getComposerDestinationById($messageId);
            $pv = $compDest->getData();
            
            // it should not be null
            if (is_null($pv))
                throw new \Exception('Message destination does not have personalised values for update.');
            
            // perform validation
            $this->validatePersonalisedValuesForUpdate($compDest->getPhoneNumber(), $newValues, $pv->export());
            
            // perform the update
            return $this->updateComposerDestinationValues($compDest, $newValues);
        }
        
        public function updatePersonalisedValues($phoneNumber, $newValues, $prevValues = null) {
            // perform validation
            $this->validatePersonalisedValuesForUpdate($phoneNumber, $newValues, $prevValues);
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            // If no previous values specified, then any existing list of
            // destinations for the phone number will be replaced
            if (is_null($prevValues)){
                return $this->replacePersonalisedValues($fmtdNumber, $newValues);
            }
            else {
                // new personalised values should not already exist for the destination
                if ($this->valuesExist($this->getPersonalisedValues($fmtdNumber), $newValues))
                    throw new \Exception("The new personalised values already exist for destination '{$fmtdNumber}'.");
                    
                $compDestsStore = $this->getComposerDestinations($fmtdNumber);
                
                // iterate for the one with the specified values
                foreach ($compDestsStore->getItems() as $compDest){
                    $cpv = $compDest->getData();  // current personalised values
                    
                    // If values are not the same, get next one
                    if (join(',', $cpv->export()) !== join(',', $prevValues))
                        continue;
                    
                    // we have it, update the values
                    return $this->updateComposerDestinationValues($compDest, $newValues);
                }
                
                return false;
            }
        }
        
        private function updateComposerDestinationValues($compDest, $valuesArr){
            $scheduled = $compDest->isScheduled();
            $messageId = $compDest->getMessageId();
            $phoneNumber = $compDest->getPhoneNumber();
            $destMode = $scheduled ? DestinationMode::DM_UPDATE : $compDest->getWriteMode();
            
            // create new personalised values object
            $pValues = new PersonalisedValues($valuesArr);
            $newCompDest = $this->createComposerDestination($phoneNumber, $messageId, $destMode, $pValues, $scheduled);
            $countryCode = $this->getDestinationCountryCode($phoneNumber);
            
            // remove and replace with new
            if ($this->removeComposerDestination($compDest)) {
                $this->addComposerDestination($newCompDest, $countryCode);
                return true;
            }
            
            return false;
        }
        
        public function updatePersonalisedValuesWithId($phoneNumber, $newValues, $newMessageId) {
            if (is_null($phoneNumber) || !PhoneUtil::isValidPhoneNumber($phoneNumber))
                throw new \Exception('Invalid destination phone number for updating values.');
            
            // validate message identifier
            if (is_null($newMessageId) || empty($newMessageId))
                throw new \Exception('Invalid message identifier for updating personalised values.');
            
            // message identifier should not already exist
            if ($this->messageIdExists($newMessageId))
                throw new \Exception("Message identifier '{$newMessageId}' already exists.");
                
            // formatting
            $numberInfo = $this->formatPhoneNumber($phoneNumber);
            $fmtdNumber = $numberInfo[0];
            
            if (!$this->formattedDestinationExists($fmtdNumber))
                throw new \Exception("Phone number '{$phoneNumber}' does not exist.");

            // call for replacement
            return $this->replacePersonalisedValues($fmtdNumber, $newValues, $newMessageId);
        }
        
        private function replacePersonalisedValues($phoneNumber, $newValues, $messageId = null){
            // message should be personalised
            if (!$this->isPersonalised())
                throw new \Exception('Message is not personalised for updating values.');
            
            // perform validation
            $this->validatePersonalisedValuesForUpdate($phoneNumber, $newValues);
            
            // begin replacement
            $fmtdNumber = $this->getFormattedPhoneNumber($phoneNumber);
            $countryCode = $this->getDestinationCountryCode($fmtdNumber);
            $compDestsStore = $this->getMappedDestinations($fmtdNumber);
            
            // remove any associated composer destinations list
            $this->removeComposerDestinationsList($fmtdNumber, $compDestsStore);
            
            // create new for replacement
            $destMode = DestinationMode::DM_ADD;
            $psndValues = new PersonalisedValues($newValues);
            $compDest = $this->createComposerDestination($fmtdNumber, $messageId, $destMode, $psndValues);
            
            // add and return
            $this->addComposerDestination($compDest, $countryCode);
            return true;
        }
     
        public function setMessage($message, $psnd = null){
            if (is_null($message) || empty($message))
                throw new \Exception('Invalid message text.');
            
            if (!is_null($psnd) && !is_bool($psnd))
                throw new \Exception('Invalid message personalisation flag.');

            $varsCount = self::getMessageVariablesCount($message);
            
            if (!is_null($psnd) && $psnd === true && $varsCount == 0)
                throw new \Exception('Message text does not contain variables to personalise messages.');
            
            // get current message text, if there is
            $currMessageText = $this->getMessage();
            
            // set true or false value for 'psnd'
            if (is_null($psnd)){
                $psnd = $varsCount > 0;
            }
            
            if (!is_null($currMessageText) && !empty($currMessageText)){
                // If this message composer was created from scheduled message, then we 
                // will want that both to be the same in terms of being personalised or not.
                // And if personalised, they should have the same number of variables
                if ($this->isScheduled())
                    $this->validateScheduledMessageTextUpdate($message, $psnd === true);
                
                // If the message was not previously personalised,
                // then any existing destinations will have to be cleared
                if (($psnd && !$this->isPersonalised()) ||  (!$psnd && $this->isPersonalised()))
                    $this->clearDestinations();
            }
            
            // Set the message text
            $this->_message = $message;
            $this->_isPsnd = $psnd;
        }
        
        private function validateScheduledMessageTextUpdate($newMessageText, $isPsnd){
            if ($isPsnd && !$this->isPersonalised()){
                // loaded message is not personalised but current message is to be personalised
                throw new \Exception("Cannot replace non-personalised scheduled ".
                    "message with a personalised message.");
            }

            // If the scheduled message was personalised and the new message to be set
            // is not personalised, we will not allow it
            if (!$isPsnd && $this->isPersonalised()) {
                throw new Exception("Mismatch variables count in scheduled message ".
                    "text and replacement message text.");
            }

            // If both are personalised, they should have the same number of variables defined in them
            if ($isPsnd && $this->isPersonalised()){
                $schedVarsCount = self::getMessageVariablesCount($newMessageText);
                $newMessageVarsCount = self::getMessageVariablesCount($newMessageText);
                
                if ($schedVarsCount !== $newMessageVarsCount) {
                    throw new Exception("Mismatch variables count in scheduled message ".
                        "text and replacement message text.");
                }
            }
        }

        public function setWapURL($url) {
            if (is_null($url)) {
                $this->_wpushURL = $url;
                return;
            }
            
            // ensure we have a valid address.
            $this->_wpushURL = $url;
        }
        
        public function getWapURL() {
            return $this->_wpushURL;
        }
        
        public function getMessageType(){
            return $this->_type;
        }
        
        public function setMessageType($type) {
            if (is_null($type))
                throw new \Exception('Invalid text message type.');
            
            // If not enum type convert
            if (TextMessageType::isDefined($type)){
                $this->_type = $type;
            }
            else if (is_string($type)){
                $this->_type = MessageUtil::messageTypeToEnum($type);
            }
            else {
                throw new \Excception('Unknown text message type specifier.');
            }
        }
        
        public function setSender($sender) {
            if (is_null($sender) || empty($sender))
                throw new \Exception('Missing or invalid message sender identifier.');
            
            if (PhoneUtil::isValidPhoneNumber($sender)) {
                if (strlen($sender) > self::NUMERIC_SENDER_MAX_LEN)
                    throw new \Exception('Numeric sender identifier must not be greater tnan '.
                        self::NUMERIC_SENDER_MAX_LEN.' characters.');
            }
            else {
                if (strlen($sender) > self::ALPHA_NUMERIC_SENDER_MAX_LEN)
                    throw new \Exception('Alpha-numeric sender identifier must not be greater than '.
                        self::ALPHA_NUMERIC_SENDER_MAX_LEN.' characters.');
            }
            
            // parent will set it
            parent::setSender($sender);
        }
    }
