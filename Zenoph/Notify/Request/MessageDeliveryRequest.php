<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Enums\DataContentType;
    use Zenoph\Notify\Response\MessageResponse;
    
    class MessageDeliveryRequest extends NotifyRequest {
        private $_templateId = null;
        
        public function __construct($authProfile = null) {
            parent::__construct($authProfile);
        }
        
        public function setTemplateId($templateId){
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message identifier for delivery request.');
            
            $this->_templateId = $templateId;
        }
        
        public function submit() {
            if (is_null($this->_templateId) || empty($this->_templateId))
                throw new \Exception('Message identifier has not been set for delivery status request.');
            
            $this->setRequestResource("report/message/delivery/{$this->_templateId}");
            $this->setResponseContentType(DataContentType::DCT_GZBIN_XML);
            
            // initiate for request writing
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeMessageDeliveryRequest($this->_templateId);
            
            // submit for response
            $apiResponse = parent::submit();
            
            // create and return message response
            return MessageResponse::create($apiResponse);
        }
    }