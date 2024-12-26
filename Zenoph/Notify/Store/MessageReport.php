<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Store;
    
    use Zenoph\Notify\Enums\MessageValidation;
    
    class MessageReport {
        private $_messageValidation = MessageValidation::MV_NONE;
        private $_messageValidationTag = null;
        private $_reference = null;
        private $_destinations = null;
        private $_destsCount = 0;
        private $_category = null;
        private $_text = null;
        private $_type = null;
        private $_sender = null;
        private $_personalised = false;
        private $_deliveryReport = false;
        
        private function __construct() {
            $this->_destinations = array();
        }
 
        public static function create(&$p){
            $msgReport = new MessageReport();
            
            if (array_key_exists('reference', $p))
                $msgReport->_reference = $p['reference'];
            
            if (array_key_exists('category', $p))
                $msgReport->_category = $p['category'];
            
            if (array_key_exists('text', $p))
                $msgReport->_text = $p['text'];
            
            if (array_key_exists('type', $p)) {
                $msgReport->_type = $p['type'];
            }
            
            if (array_key_exists('sender', $p))
                $msgReport->_sender = $p['sender'];
            
            if (array_key_exists('personalised', $p))
                $msgReport->_personalised = $p['personalised'];
            
            if (array_key_exists('delivery', $p))
                $msgReport->_deliveryReport = $p['delivery'];
            
            // When message validation fails, there won't be any destinations.
            if (array_key_exists('destinations', $p))
                $msgReport->_destinations = $p['destinations'];
            
            if (array_key_exists('validation', $p)) {
                $msgReport->_messageValidation = $p['validation'];
                
                if (array_key_exists('validationTag', $p))
                    $msgReport->_messageValidationTag = $p['validationTag'];
            }
            
            if (array_key_exists('destsCount', $p)) {
                $msgReport->_destsCount = $p['destsCount'];
            }
            else {
                $msgReport->_destsCount = $msgReport->_destinations->getCount();
            }
            
            // return message report
            return $msgReport;
        }
        
        public function getValidation(){
            return $this->_messageValidation;
        }
        
        public function getValidationTag(){
            return $this->_messageValidationTag;
        }
        
        public function getDestiniationsCount(){
            return $this->_destinations->getCount();
        }
        
        public function getDestinations(){
            return $this->_destinations;
        }
        
        public function getReference(){
            return $this->_reference;
        }
        
        public function getSender(){
            return $this->_sender;
        }
        
        public function getMessage(){
            return $this->_text;
        }
        
        public function getMessageType(){
            return $this->_type;
        }
        
        public function getMessageCategory(){
            return $this->_category;
        }
        
        public function isPersonalised(){
            return $this->_personalised;
        }
        
        public function isDeliveryReport(){
            return $this->_deliveryReport;
        }
    }