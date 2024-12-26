<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choos e Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Enums\TextMessageType;
    use Zenoph\Notify\Response\MessageResponse;
    use Zenoph\Notify\Compose\SMSComposer;
    use Zenoph\Notify\Compose\ISMSComposer;
    
    class SMSRequest extends MessageRequest implements ISMSComposer {
        protected static $messageTypes = null;
        private static $_baseResource = 'message/sms/send';
    
        public function __construct($authProfile = null) {
            parent::__construct($authProfile);
            
            if (is_null($authProfile))
                $this->_composer = new SMSComposer();
            else
                $this->_composer = new SMSComposer($authProfile);
        }

        protected function validate() {
            parent::validate();
            
            // message sender is mandatory for text messages
            $sender = $this->_composer->getSender();
            $messageType = $this->_composer->getMessageType();
            
            // check message sender
            if (is_null($sender) || empty($sender))
                throw new \Exception("Message sender has not been set.");
            
            // for wap push message, URL must be set.
            if ($messageType == TextMessageType::WAP_PUSH){
                $wapUrl = $this->_composer->getWapURL();
                
                if (is_null($wapUrl) || empty($wapUrl))
                    throw new \Exception("URL has not been set for the wap push message.");
            }
        }
        
        public static function getBaseResource(){
            return self::$_baseResource;
        }
        
        public function submit(){
            $this->setRequestResource(self::$_baseResource);
            $tmcArr = array($this->_composer);
            
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeSMSRequest($tmcArr);

            // submit for response
            $response = parent::submit();

            // Create and return the message response object
            return MessageResponse::create($response); 
        }

        public static function submitComposer(&$sc, $param1, $param2 = null) {
            if (is_null($sc) || ! $sc instanceof SMSComposer)
                throw new \Exception('Invalid SMS composer object for dispatching message.');
            if (is_null($param1))
                throw new \Exception('Invalid authentication parameter for dispatching message.');
             
            $sr = new SMSRequest();
            $sr->_composer = $sc;
            self::initRequestAuth($sr, $param1, $param2);
            
            return $sr->submit();
        }
        
        public static function getMessageCount($message, $type){
            return SMSComposer::getMessageCount($message, $type);
        }
        
        public function getRegisteredSenderIds() {
            $this->assertComposer();
            return $this->_composer->getRegisteredSenderIds();
        }
          
        public function setMessageType($type) {
            $this->assertComposer();
            $this->_composer->setMessageType($type);
        }
  /*      
        public function setMessageCategory($category) {
            $this->assertComposer();
            $this->_composer->setMessageCategory($category);
        }
    */    
        public function setWapURL($url) {
            $this->assertComposer();
            $this->_composer->setWapURL($url);
        }
        
        public function getWapURL() {
            $this->assertComposer();
            return $this->_composer->getWapURL();
        }
        
        public function isPersonalised() {
            $this->assertComposer();
            return $this->_composer->isPersonalised();
        }
        
        public function getDefaultMessageType() {
            $this->assertComposer();
            return $this->_composer->getDefaultMessageType();
        }
        
        public function getPersonalisedValues($phoneNumber) {
            $this->assertComposer();
            return $this->_composer->getPersonalisedValues($phoneNumber); 
        }
        
        public function getPersonalisedValuesById($messageId) {
            $this->assertComposer();
            return $this->_composer->getPersonalisedValuesById($messageId);
        }
        
        public function updatePersonalisedValuesById($destId, $values) {
            $this->assertComposer();
            return $this->_composer->updatePersonalisedValuesById($destId, $values);
        }
        
        public function updatePersonalisedValues($phoneNumber, $newValues, $prevValues = null) {
            $this->assertComposer();
            return $this->_composer->updatePersonalisedValues($phoneNumber, $newValues, $prevValues);
        }
        
        public function updatePersonalisedValuesWithId($phoneNumber, $newValues, $newMessageId) {
            $this->assertComposer();
            return $this->_composer->updatePersonalisedValuesWithId($phoneNumber, $newValues, $newMessageId);
        }
        
        public function removePersonalisedValues($phoneNumber, $values) {
            $this->assertComposer();
            return $this->_composer->removePersonalisedValues($phoneNumber, $values);
        }
        
        public function removePersonalisedDestination($phoneNumber, $values) {
            $this->assertComposer();
            return $this->_composer->removePersonalisedDestination($phoneNumber, $values);
        }
        
        public function addPersonalisedDestination($phoneNumber, $throwEx, $values, $messageId = null) {
            $this->assertComposer();
            return $this->_composer->addPersonalisedDestination($phoneNumber, $throwEx, $values, $messageId);
        }
        
        public function getPersonalisedDestinationMessageId($phoneNumber, $values) {
            $this->assertComposer();
            return $this->_composer->getPersonalisedDestinationMessageId($phoneNumber, $values);
        }
        
        public function getPersonalisedDestinationWriteMode($phoneNumber, $values) {
            $this->assertComposer();
            return $this->_composer->getPersonalisedDestinationWriteMode($phoneNumber, $values);
        }
       
        public function personalisedValuesExists($phoneNumber, $values) {
            $this->assertComposer();
            return $this->_composer->personalisedValuesExists($phoneNumber, $values);
        }
        
        public function getMessageType() {
            $this->assertComposer();
            return $this->_composer->getMessageType();
        }

        public static function getMessageVariablesCount($message) {
            return SMSComposer::getMessageVariablesCount($message);
        }
        
        public static function &getMessageVariables($message, $trim = false){
            return SMSComposer::getMessageVariables($message, $trim);
        }
    }