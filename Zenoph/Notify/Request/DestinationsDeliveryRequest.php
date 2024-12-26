<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Response\MessageResponse;
    
    class DestinationsDeliveryRequest extends NotifyRequest {
        private $_messageIds = null;
        private $_templateId = null;
        
        public function __construct($authProfile = null) {
            parent::__construct($authProfile);
        }
        
        public function addMessageId($messageId){
            if (is_null($messageId) || empty($messageId))
                throw new \Exception('Invalid destination identifier for delivery request.');
            
            $this->_messageIds[] = $messageId;
        }
        
        public function setTemplateId($templateId){
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message template identifier.');
            
            $this->_templateId = $templateId;
        }
        
        public function setMessageReference($ref){
            $this->setTemplateId($ref);
        }
        
        private function validate(){
            if (is_null($this->_templateId) || empty($this->_templateId))
                throw new \Exception('Message template identifier has not been set for writing request.');
            
            if (is_null($this->_messageIds) || count($this->_messageIds) == 0)
                throw new \Exception('There are no message identifiers for writing request.');
        }
        
        public function submit() {
            // perform validation
            $this->validate();
            
            $this->setRequestResource("report/message/delivery/destinations");
            $this->setResponseContentType(DataContentType::GZBIN_XML);
            
            // initialise for writing request
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeDestinationsDeliveryRequest(
                    $this->_templateId,  
                    $this->_messageIds
                );
            
            // submit for response
            $apiResponse = parent::submit();
            
            // create and return message response
            return MessageResponse::create($apiResponse);
        }
    }