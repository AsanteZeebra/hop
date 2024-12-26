<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Response\MessageResponse;
    use Zenoph\Notify\Enums\MessageCategory;
    
    class MultiSMSRequest extends NotifyRequest{
        private $_messagesList;
        
        public function __construct($authProfile = null) {
            parent::__construct($authProfile);
            $this->_messagesList = array();
        }
        
        public function createMessage(){
            // Create and return a new TextMessage object
            if (is_null($this->_authProfile))
                return new TextMessage();
            else
                return new TextMessage($this->_authProfile);
        }
        
        public function addMessage(&$mc){
            if (is_null($mc) || !($mc instanceof SMSComposer))
                throw new \Exception('Invalid reference to message object.');
            
            // we only allow for SMS message category
            $this->assertMessageCategory($mc);
            
            // add to the messages list
            $this->_messagesList[] = $mc;
        }
        
        private function assertMessageCategory($mc){
            // For multi-messages, we only allow for SMS message category
            if ($mc->getCategory() != MessageCategory::MC_SMS)
                throw new \Exception("Multi-messages are allowed only for SMS message category.");
        }
        
        public function submit() {
            // get SMS request resource
            $requestResource = SMSRequest::getBaseResource();
            
            // set resource and response data type
            $this->setRequestResource($requestResource);
            $this->setResponseContentType(DataContentType::GZBIN_XML);
            
            // initiate for writing request
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeSMSRequest($this->_messagesList);
            
            // Submit request and return response
            $apiResp = parent::submit();
            return MessageResponse::create($apiResp);
        }
    }