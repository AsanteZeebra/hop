<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Store;
    
    use Zenoph\Notify\Enums\DestinationMode;
    
    class ComposerDestination {
        private $_destMode;
        private $_phoneNumber = null;
        private $_messageId = null;
        private $_destData = null;
        private $_scheduled = false;
        
        public function __construct() {
            $this->_destMode = DestinationMode::DM_NONE;
        }
        
        public static function &create(&$data){
            if (is_null($data) || !is_array($data))
                throw new \Exception("Invalid object reference for initialising message composer destination.");
            
            // validate the data
            self::validateCreateData($data);
            
            // create object and set data
            $cd = new ComposerDestination();
            $cd->_destMode = $data['destMode'];
            $cd->_phoneNumber = $data['phoneNumber'];
            $cd->_messageId = $data['messageId'];
            $cd->_destData = $data['destData'];
            $cd->_scheduled = $data['scheduled'];
            
            // return the composer destination
            return $cd;
        }
        
        private static function validateCreateData(&$data){
            if (!array_key_exists('destMode', $data))
                throw new \Exception('Destination mode specifier not set.');
            
            if (!array_key_exists('phoneNumber', $data))
                throw new \Exception('Phone number not specified for composer destination.');
            
            if (!array_key_exists('messageId', $data))
                throw new \Exception('Message identifier not specified for composer destination.');
            
            if (!array_key_exists('destData', $data))
                throw new \Exception('Custom data not specified for composer destination.');
            
            if (!array_key_exists('scheduled', $data))
                throw new \Exception('Scheduling indicator not specified for composer destination.');
        }
        
        public function reset(){
            // reset is only allowed on on scheduled destinations that have been loaded
            if (!$this->_scheduled)
                throw new \Exception('Cannot reset write mode for non-scheduled destinations.');
            
            // set to none
            $this->_destMode = DestinationMode::DM_NONE;
        }
        
        public function getMessageId(){
            return $this->_messageId;
        }
        
        public function getPhoneNumber(){
            return $this->_phoneNumber;
        }
        
        public function getWriteMode(){
            return $this->_destMode;
        }
        
        public function getData() {
            return $this->_destData;
        }
        
        public function isScheduled(){
            return $this->_scheduled;
        }
    }