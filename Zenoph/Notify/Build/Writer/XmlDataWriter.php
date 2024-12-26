<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    namespace Zenoph\Notify\Build\Writer;
    
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Utils\RequestUtil;
    use Zenoph\Notify\Enums\DestinationMode;
    use Zenoph\Notify\Enums\TextMessageType;
    use Zenoph\Notify\Enums\MessageCategory;
    use Zenoph\Notify\Store\PersonalisedValues;
    use Zenoph\Notify\Build\Writer\DataWriter;
    use Zenoph\Notify\Compose\Composer;
    use Zenoph\Notify\Compose\SMSComposer;
    use Zenoph\Notify\Compose\MessageComposer;
    use Zenoph\Notify\Compose\VoiceComposer;
    
    class XmlDataWriter extends DataWriter {
        const __AUTH_PLACEHOLDER__ = '%authPH%';
        const __DATA_PLACEHOLDER__ = '%dataPH%';
        private $_REQ_STR_TPL__ = null;
        private $_requestBody = null;
        
        public function __construct() {
            parent::__construct();
            
            $this->_REQ_STR_TPL__ = "<request>".self::__DATA_PLACEHOLDER__."</request>";
                
            // set request body to the template
            $this->_requestBody = $this->_REQ_STR_TPL__;
        }
        
        private static function initXmlWriter(){
            $writer = new \XMLWriter();
            $writer->openMemory();
            
            return $writer;
        }
    
        public function &writeSMSRequest($tmcArr) {
            if (is_null($tmcArr) || !is_array($tmcArr) || count($tmcArr) == 0)
                throw new \Exception('Invalid reference to list for writing SMS request data.');
            
            // embed authentication fragment
        //    $this->embedAuthData();
            
            // create xmlWriter and start writing
            $writer = self::initXmlWriter();
            $writer->startElement('messages');
            
            foreach ($tmcArr as $tmc){
                // ensure it is a TextMessageComposer object
                if ($tmc instanceof SMSComposer === false)
                    throw new \Exception('Invalid object reference for writing SMS request.');
                
                $writer->startElement('message');
                
                // write message properties
                $this->writeSMSProperties($tmc, $writer);
                
                // write messagedestinations
                $this->writeDestinations($tmc, $writer);
                
                $writer->endElement();  // end message element
            }
            $writer->endElement();  // end messages element
            
            // get fragment and embed in request body
            $xmlFragment = $writer->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        private function writeSMSProperties($tmc, $xmlWriter){
            $messageText = $tmc->getMessage();
            $messageType = $tmc->getMessageType();
            $category = $tmc->getCategory();
            
            $categoryLabel = $category == MessageCategory::MC_SMS ? "sms" : "ussd";
            
            // start writing message properties
            $xmlWriter->writeElement('category', $categoryLabel);
            $xmlWriter->writeElement('text', $messageText);
            $xmlWriter->writeElement('type', $messageType);
            $xmlWriter->writeElement('sender', $tmc->getSender());
            
            // If wap push message, URL must be set
            if ($messageType == TextMessageType::WAP_PUSH){
                $wapURL = $tmc->getWapURL();
                
                if (is_null($wapURL) || empty($wapURL))
                    throw new \Exception('URL for wap push message has not been set.');
                
                // write it
                $xmlWriter->writeElement('wapURL', $wapURL);
            }
            
            if (SMSComposer::getMessageVariablesCount($messageText) > 0){
                if (!$tmc->isPersonalised())
                    $xmlWriter->writeElement ('isPsnd', "false");
            }
     /*       
            // if USSD message
            if ($tmc->getMessageCategory() == ComposerCategory::USSD)
                $this->writeUSSDData ($tmc, $xmlWriter);
      */      
            // message properties common to both text and voice messages
            $this->writeCommonMessageProperties($tmc, $xmlWriter);
        }

        public function &writeVoiceRequest($vmcArr) {
            if (is_null($vmcArr) || !is_array($vmcArr) || count($vmcArr) == 0)
                throw new \Exception('Invalid reference to list for writing voice message request data.');
            
            // embed auth fragment in request body
        //    $this->embedAuthData();
            
            // begin writing
            $xmlWriter = self::initXmlWriter();
            
            foreach ($vmcArr as $vmc){
                // ensure it is voicemessagecomposer object
                if ($vmc instanceof VoiceComposer === false)
                    throw new \Exception('Invalid reference to voice message composer.');
                
                // If there are multiple composers, we will not allow offline audio
                if ($vmc->isLocalAudio() && count($vmcArr) > 1)
                    throw new \Exception('Offline voice audio is not allowed in multi-voice message request.');
                
                $xmlWriter->startElement('message');
                    // write message properties
                    $this->writeVoiceProperties($vmc, $xmlWriter);
                    
                    // write destinstions
                    $this->writeDestinations($vmc, $xmlWriter);
                $xmlWriter->endElement();   // end message element
            }
            
            $xmlWriter->startElement('messages');
            $xmlWriter->endElement();   // end messages element
            
            // output
            $xmlData = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlData, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        private function writeVoiceProperties($vmc, $writer){
            if ($vmc->isOfflineAudio()) // we don't write xml data for offline audio
                throw new \Exception('Unsupported data writer for writing offline voice data.');
            
            $sender = $vmc->getSender();
            $tplRef = $vmc->getTemplateReference();
            
            // If not offline audio, then tplRef must be available
            if (!$vmc->isOfflineAudio()){
                if (is_null($tplRef) || empty($tplRef))
                    throw new \Exception('Template reference has not been set for writing voice message request.');
            }
            
            if (!is_null($tplRef) || !empty($tplRef))
                $writer->writeElement('template', $tplRef);
            
            if (!is_null($sender) && !empty($sender))
                $writer->writeElement('sender', $sender);
            
            // common message properties
            $this->writeCommonMessageProperties($vmc, $writer);
        }
        
        protected function writeCommonMessageProperties($tmc, &$writer) {
            // if message is to be scheduled
            if ($tmc instanceof MessageComposer && $tmc->schedule()){
                $scheduleInfo = $tmc->getScheduleInfo();
                $this->writeScheduleInfoData($scheduleInfo[0], $scheduleInfo[1], $writer);
            }
            
            if ($tmc->notifyDeliveries()){
                $notifyInfo = $tmc->getNotifyURLInfo();
                $this->writeNotifyInfoData($notifyInfo[0], $notifyInfo[1], $writer);
            }
        }
        
        protected function writeDestinations($mc, &$writer) {
            $compDestsList = $mc->getDestinations();
            
            // it shouldn't be empty
            if ($compDestsList->getCount() == 0)
                throw new \Exception('There are no message destinations for writing.');
            
            // start writing
            $writer->startElement('destinations');
            
            foreach ($compDestsList as $compDest){
                if ($compDest->getWriteMode() == DestinationMode::DM_NONE)
                    continue;
                
                $phoneNumber = $compDest->getPhoneNumber();
                
                if ($mc instanceof MessageComposer)
                    $mc->validateDestinationSenderName($phoneNumber);
                
                // get other values
                $messageId = $compDest->getMessageId();
                $destData  = $compDest->getData();
                
                // write destination item
                $this->writeDestinationItem($phoneNumber, $messageId, $destData, $writer);
            }
            
            $writer->endElement();  // end destinations element
        }
        
        private function writeDestinationItem($phoneNumber, $messageId, $destData, $writer){
            $writer->startElement('item');
            $this->writeDestinationInfo($phoneNumber, $messageId, $destData, $writer);
            $writer->endElement();  // end item element
        }
        
        private function writeDestinationInfo($phoneNumber, $messageId, $destData, $writer){
            // $phoneNumber and $messageId must not be null at the same time
            if ((is_null($phoneNumber) || empty($phoneNumber)) && (is_null($messageId) || empty($messageId)))
                throw new \Exception('Phone number and message identifier must not be for writing destination item.');
            
            if (!is_null($phoneNumber) && !empty($phoneNumber))
                $writer->writeElement('to', $phoneNumber);
            
            // if there is message Id write it
            if (!is_null($messageId) && !empty($messageId))
                $writer->writeElement('id', $messageId);
            
            // If there is data, then it is PersonalisedValues
            if (!is_null($destData)){
                if ($destData instanceof PersonalisedValues)
                    $this->writeDestinationPersonalisedValues($destData, $writer);
            }
        }
        
        private function writeDestinationPersonalisedValues($pv, $writer){
            $writer->startElement('values');
                foreach ($pv as $value){
                    $writer->writeElement('value', $value);
                }
            $writer->endElement();  // end values element
        }
        
        protected function writeScheduleInfoData($dateTime, $utcOffset, &$writer) {
            $this->validateScheduleInfo($dateTime, $utcOffset);
            
            $writer->startElement('schedule');
                $writer->writeElement('dateTime', MessageUtil::dateTimeToStr($dateTime));
                
                // If there is UTC offset, write it
                if (!is_null($utcOffset) && !empty($utcOffset))
                    $writer->writeElement('utcOffset', $utcOffset);
            $writer->endElement();   // end schedule element
        }
        
        protected function writeNotifyInfoData($url, $contentType, &$writer) {
            $this->validateDeliveryNotificationInfo($url, $contentType);
            
            // write
            $writer->startElement('notify');
                $writer->writeElement('url', $url);
                $writer->writeElement('accept', RequestUtil::getDataContentTypeLabel($contentType));
            $writer->endElement();   // end notify element
        }
        
        public function &writeDestinationsData($mc) {
            if (is_null($mc))
                throw new \Exception('Invalid reference to message object for writing destinations.');
            
            // embed authentication in request body
        //    $this->embedAuthData();
            
            // initialise xmlwriter
            $xmlWriter = self::initXmlWriter();
            
            // write destinations
            $this->writeDestinations($mc, $xmlWriter);
            
            // get and write xml fragment in request body
            $xmlFragment = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body string
            return $this->_requestBody;
        }
    /*    
        public  function &writeCreditBalanceRequest() {
        //    return $this->writeAuthRequest();
        }
   */     
        public function &writeDestinationsDeliveryRequest($templateId, $messageIdsArr) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message template identifier for destinations delivery request.');
            
            if (is_null($messageIdsArr) || !is_array($messageIdsArr))
                throw new \Exception('Invalid reference for writing message identifiers.');
            
            if (count($messageIdsArr) == 0)
                throw new \Exception('There are no message identifiers for writing destination delivery request.');
            
            // embed authentication details first
        //    $this->embedAuthData();
            $xmlWriter = self::initXmlWriter();
            
            // template Id
            $this->writeMessageReferenceId($templateId, $xmlWriter);
            
            // write message Ids
            $xmlWriter->startElement('destinations');
            
            foreach ($messageIdsArr as $messageId){
                if (!is_null($messageId) && !empty($messageId))
                    $xmlWriter->writeElement('id', $messageId);
            }
            
            $xmlWriter->endElement();   // end destinations element
            
            // prepare output
            $xmlFragment = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        public function &writeScheduledMessagesLoadRequest($filter) {
            $this->validateScheduledMessagesLoadData($filter);
            
            // embed auth details now
        //    $this->embedAuthData();
            $xmlWriter = self::initXmlWriter();
            
            // If templateId is specified, then we should load specific message
            $templateId = $filter['templateId'];
            
            // write message element
        //    $xmlWriter->startElement('message');
            
            if (!is_null($templateId) && !empty($templateId)){
                $this->writeMessageReferenceId($templateId, $xmlWriter);
            }
            else {  // not specific
                if (!is_null($filter['category']))
                    $xmlWriter->writeElement('category', $filter['category']);
                
                // if there are dates specified
                if (!is_null($filter['dateFrom']) && !is_null($filter['dateTo'])){
                    $xmlWriter->startElement('dateTime');
                        $xmlWriter->writeElement('from', MessageUtil::dateTimeToStr($filter['dateFrom']));
                        $xmlWriter->writeElement('to', MessageUtil::dateTimeToStr($filter['dateTo']));
                        
                        // If UTC offset is specified, then we write it
                        if (!is_null($filter['utcOffset']) && !empty($filter['utcOffset']))
                            $xmlWriter->writeElement('utcOffset', $filter['utcOffset']);
                        
                    $xmlWriter->endElement();   // end dateTime element
                }
            }
            
            // end message element
        //    $xmlWriter->endElement();
            
            // prepare output
            $xmlFragment = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        public function &writeScheduledMessageUpdateRequest($mc) {
            if (is_null($mc) || $mc instanceof Composer === false)
                throw new \Exception('Invalid object reference for writing scheduled message update request.');
            
        //    $this->embedAuthData();
            $xmlWriter = self::initXmlWriter();
            $category = $mc->getCategory();
            
            // begin writing
        //    $xmlWriter->startElement('message');
                $this->writeMessageReferenceId($mc->getTemplateId(), $xmlWriter);
                
                // message properties to be written will depend on the category
                if ($category == MessageCategory::MC_SMS || $category == MessageCategory::MC_USSD)
                    $this->writeSMSProperties ($mc, $xmlWriter);
                else /// voice message then
                    $this->writeVoiceProperties ($mc, $xmlWriter);
                
                // see if there are destinations to be written
                if ($mc->getDestinationsCount() > 0)
                    $this->writeScheduledMessageDestinations($mc, $xmlWriter);
                
        //    $xmlWriter->endElement();   // end message element
            
            // prepare output
            $xmlFragment = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        private function writeScheduledMessageDestinations($mc, $xmlWriter){
            // get the destinations
            $compDestsList = $mc->getDestinations();
            
            if (is_null($compDestsList) || $compDestsList->getCount() == 0)
                return;
            
            // individual writers for adding, updating, and deleting destinations
            $addWriter = self::initXmlWriter();
            $updateWriter = self::initXmlWriter();
            $deleteWriter = self::initXmlWriter();
            
            foreach ($compDestsList as $compDest){
                $destMode = $compDest->getWriteMode();
                
                // if destination mode is NONE, we will not write
                if ($destMode == DestinationMode::DM_NONE)
                    continue;
                
                $phoneNumber = $compDest->getPhoneNumber();
                $mc->validateDestinationSenderName($phoneNumber);
                
                // other data
                $destData = $compDest->getData(); 
                $messageId = $compDest->getMessageId();
                
                switch ($destMode){
                    case DestinationMode::DM_ADD:
                        $this->writeDestinationItem($phoneNumber, $messageId, $destData, $addWriter);
                        break;
                    
                    case DestinationMode::DM_UPDATE:
                        $this->writeDestinationItem($phoneNumber, $messageId, $destData, $updateWriter);
                        break;
                    
                    case DestinationMode::DM_DELETE:
                        $this->writeDestinationItem(null, $messageId, null, $deleteWriter);
                        break;
                }
            }
            
            // get individual writer fragments
            $addXml = $addWriter->outputMemory();
            $updateXml = $updateWriter->outputMemory();
            $deleteXml = $deleteWriter->outputMemory();
            
            $xmlWriter->startElement('destinations');
            
            // begin writing
            if (!is_null($addXml) && !empty($addXml)) {
                $xmlWriter->startElement('add');
                $xmlWriter->writeRaw($addXml);
                $xmlWriter->endElement();   // end add element
            }
            
            if (!is_null($updateXml) && !empty($updateXml)){
                $xmlWriter->startElement('update');
                $xmlWriter->writeRaw($updateXml);
                $xmlWriter->endElement();   // end update element
            }
            
            if (!is_null($deleteXml) && !empty($deleteXml)){
                $xmlWriter->startElement('delete');
                $xmlWriter->writeRaw($deleteXml);
                $xmlWriter->endElement();   // end delete element
            }
            
            // end destinations element
            $xmlWriter->endElement();
        }
        
        public function &writeUSSDRequest($ucArr) {
            
        }
        
        private function writeUSSDData($tmc, $xmlWriter){
            // in future implementation
        }
        
        private function &writeTemplateIdArgumentRequest($reference){
        //    $this->embedAuthData();
            $xmlWriter = self::initXmlWriter();
            
            // write template Id
            $this->writeMessageReferenceId($reference, $xmlWriter);
            
            // prepare output
            $xmlFragment = $xmlWriter->outputMemory();
            $this->_requestBody = str_replace(self::__DATA_PLACEHOLDER__, $xmlFragment, $this->_requestBody);
            
            // return request body
            return $this->_requestBody;
        }
        
        public function &writeMessageDeliveryRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid template identifier for writing message delivery request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeScheduledMessageDestinationsLoadRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid template identifier for writing scheduled message destinations load request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeCancelScheduleRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid template identifier for cancelling message scheduling.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeDispatchScheduledMessageRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid template identifier for writing scheduled message dispatch request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        private function writeMessageReferenceId($reference, $xmlWriter){
            $xmlWriter->writeElement('reference', $reference);
        }
    }