<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
   
    use Zenoph\Notify\Compose\IComposer;
    
    abstract class ComposeRequest extends NotifyRequest implements IComposer {
        protected $_composer = null;
        
        public function __construct($ap = null) {
            parent::__construct($ap);
        }
        
        protected function assertComposer(){
            if (is_null($this->_composer))
                throw new \Exception('Invalid reference to message composer object.');
        }
   
        protected function validate(){
            $this->assertComposer();
            $message = $this->_composer->getMessage();
            
            if (is_null($message) || empty($message))
                throw new \Exception("Message body has not been set.");
            
            // there should be message destinations
            if ($this->_composer->getDestinationsCount() == 0)
                throw new \Exception("There are no destinations for submitting message.");
        }
        
        public function getComposer(){
            return $this->_composer;
        }
        
        public function setAuthProfile($ap) {
            // validate auth profile
            $this->validateAuthProfile($ap);
            
            // composer object must already be initialised
            if (is_null($this->_composer))
                throw new \Exception('Composer object has not been initialised.');
            
            // set the user object data
            $this->_composer->setUserData($ap->getUserData());
            
            // parent will set auth profile
            parent::setAuthProfile($ap);
        }
        
        public function getRouteCountries(){
            $this->assertComposer();
            return $this->_composer->getRouteCountries();
        }
     
        public function getDefaultNumberPrefix() {
            $this->assertComposer();
            return $this->_composer->getDefaultNumberPrefix();
        }
        
        public function setDefaultNumberPrefix($dialCode) {
            $this->assertComposer();
            $this->_composer->setDefaultNumberPrefix($dialCode);
        }
        
        public function setNotifyURL($url, $contentType) {
            $this->assertComposer();
            $this->_composer->setNotifyURL($url, $contentType);
        }
        
        public function getNotifyURLInfo() {
            $this->assertComposer();
            return $this->_composer->getNotifyURLInfo();
        }
        
        public function setMessage($message, $info = null) {
            $this->assertComposer();
            $this->_composer->setMessage($message, $info);
        }
        
        public function getMessage() {
            $this->assertComposer();
            return $this->_composer->getMessage();
        }

        public function notifyDeliveries() {
            $this->assertComposer();
            return $this->_composer->notifyDeliveries();
        }

        public function getDefaultTimeZone(){
            $this->assertComposer();
            return $this->_composer->getDefaultTimeZone();
        }
        
        public function getDestinationCountry($phoneNumber){
            $this->assertComposer();
            return $this->_composer->getDestinationCountry($phoneNumber);
        }
        
        public function getDefaultDestinationCountry(){
            $this->assertComposer();
            return $this->_composer->getDefaultDestinationCountry();
        }
        
        public function getDestinationWriteMode($phoneNumber) {
            $this->assertComposer();
            return $this->_composer->getDestinationWriteMode($phoneNumber);
        }
        
        public function getDestinationWriteModeById($messageId) {
            $this->assertComposer();
            return $this->_composer->getDestinationWriteModeById($messageId);
        }
        
        public function getDestinations() {
            $this->assertComposer();
            return $this->_composer->getDestinations();
        }
        
        public function getDestinationsCount() {
            $this->assertComposer();
            return $this->_composer->getDestinationsCount();
        }
        
        public function updateDestination($prePhoneNumber, $newPhoneNumber) {
            $this->assertComposer();
            return $this->_composer->updateDestination($prePhoneNumber, $newPhoneNumber);
        }
        
        public function updateDestinationById($messageId, $newPhoneNumber) {
            $this->assertComposer();
            return $this->_composer->updateDestinationById($messageId, $newPhoneNumber);
        }
        
        public function clearDestinations() {
            $this->assertComposer();
            $this->_composer->clearDestinations();
        }
        
        public function getMessageId($phoneNumber) {
            $this->assertComposer();
            return $this->_composer->getMessageId($phoneNumber);
        }
        
        public function messageIdExists($messageId) {
            $this->assertComposer();
            return $this->_composer->messageIdExists($messageId);
        }
        
        public function addDestinationsFromTextStream(&$str) {
            $this->assertComposer();
            return $this->_composer->addDestinationsFromTextStream($str);
        }
        
        public function addDestinationsFromCollection(&$phoneNumbers, $throwEx = false) {
            $this->assertComposer();
            return $this->_composer->addDestinationsFromCollection($phoneNumbers, $throwEx);
        }
        
        public function addDestination($phoneNumber, $throwEx = true, $messageId = null) {
            $this->assertComposer();
            return $this->_composer->addDestination($phoneNumber, $throwEx, $messageId);
        }
        
        public function removeDestination($phoneNumber) {
            $this->assertComposer();
            return $this->_composer->removeDestination($phoneNumber);
        }
        
        public function removeDestinationById($messageId) {
            $this->assertComposer();
            return $this->_composer->removeDestinationById($messageId);
        }
        
        public function destinationExists($phonenum) {
            $this->assertComposer();
            return $this->_composer->destinationExists($phonenum);
        }

        public function getCategory() {
            $this->assertComposer();
            return $this->_composer->getCategory();
        }
    }