<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Compose\ISchedule;
    use Zenoph\Notify\Compose\IMessageComposer;
    
    abstract class MessageRequest extends ComposeRequest implements IMessageComposer, ISchedule {
        public function __construct($ap = null) {
            parent::__construct($ap);
        }
        
        public function getTemplateId() {
            $this->assertComposer();
            return $this->_composer->getTemplateId();
        }
        
        public function getReferenceId() {
            $this->assertComposer();
            return $this->_composer->getReferenceId();
        }
        
        public function setSender($sender) {
            $this->assertComposer();
            $this->_composer->setSender($sender);
        }
        
        public function getSender() {
            $this->assertComposer();
            return $this->_composer->getSender();
        }
        
        public function schedule() {
            $this->assertComposer();
            return $this->_composer->schedule();
        }
        
        public function isScheduled() {
            $this->assertComposer();
            return $this->_composer->isScheduled();
        }
        
        public function getScheduleInfo() {
            $this->assertComposer();
            return $this->_composer->getScheduleInfo();
        }
        
        public function setScheduleDateTime($dateTime, $val1 = null, $val2 = null) {
            $this->assertComposer();
            $this->_composer->setScheduleDateTime($dateTime, $val1, $val2);
        }
        
        public function validateDestinationSenderName($phoneNumber) {
            $this->assertComposer();
            $this->_composer->validateDestinationSenderName($phoneNumber);
        }
        
        public function refreshScheduledDestinationsUpdate($destsList) {
            $this->assertComposer();
            $this->_composer->refreshScheduledDestinationsUpdate($destsList);
        }
        
        public function removeDestinationById($messageId) {
            $this->assertComposer();
            return $this->_composer->removeDestinationById($messageId);
        }
        
        public function updateDestinationById($messageId, $phoneNumber) {
            $this->assertComposer();
            return $this->_composer->updateDestinationById($messageId, $phoneNumber);
        }
    }