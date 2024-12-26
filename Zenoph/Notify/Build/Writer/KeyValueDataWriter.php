<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Build\Writer;
    
    use Zenoph\Notify\Enums\TextMessageType;
    use Zenoph\Notify\Enums\MessageCategory;
    use Zenoph\Notify\Enums\DestinationMode;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Utils\RequestUtil;
    use Zenoph\Notify\Store\PersonalisedValues;
    use Zenoph\Notify\Build\Writer\DataWriter;
    use Zenoph\Notify\Compose\MessageComposer;
    use Zenoph\Notify\Compose\SMSComposer;
    use Zenoph\Notify\Compose\VoiceComposer;
    
    abstract class KeyValueDataWriter extends DataWriter {
        const PSND_VALUES_UNIT_SEP = "__@";
        const PSND_VALUES_GRP_SEP = "__#";
        const DESTINATIONS_SEPARATOR = ",";
        
        protected $_keyValueArr = null;

        public function __construct() {
            parent::__construct();
            
            $this->_keyValueArr = array();
        }

        public function &writeSMSRequest($tmcArr) {
            if (is_null($tmcArr) || !is_array($tmcArr) || count($tmcArr) == 0)
                throw new \Exception('Invalid reference for writing SMS request data.');
            
            // there must be only one item
            if (count($tmcArr) > 1)
                throw new \Exception('There must be only one message object for writing key/value message request.');
            
            $tmc = $tmcArr[0];
            $store = &$this->_keyValueArr;
            
            // write message properties
            $this->writeSMSProperties($tmc, $store);
            $this->writeCommonMessageProperties($tmc, $store);
            
            // write destinations
            $this->writeDestinations($tmc, $store);
            
            // return request data
            return $this->prepareRequestData();
        }
        
        private function writeSMSProperties($tmc, &$store){
            $messageText = $tmc->getMessage();
            $messageType = $tmc->getMessageType();
            $category = $tmc->getCategory();
            
            // append category
            $categoryLabel = $category == MessageCategory::MC_SMS ? "sms" : "ussd";
            
            $this->appendKeyValueData($store, "category", $categoryLabel);
            $this->appendKeyValueData($store, "text", $messageText);
            $this->appendKeyValueData($store, "type", $messageType);
            $this->appendKeyValueData($store, "sender", $tmc->getSender());
            
            // If wap push message, append URL
            if ($tmc->getMessageType() == TextMessageType::WAP_PUSH)
                $this->appendKeyValueData($store, "wapUrl", $tmc->getWapURL());
            
            // message personalisation flag
            if (SMSComposer::getMessageVariablesCount($messageText) > 0){
                if (!$tmc->isPersonalised())
                    $this->appendKeyValueData ($store, "isPsnd", "false");
            }
        }

        private function writeVoiceMessageProperties($vmc, &$store){
            $sender = $vmc->getSender();
            $template = $vmc->getTemplateReference();
            
            if (!is_null($sender) && !empty($sender))
                $this->appendKeyValueData($store, "sender", $sender);
            
            if (!is_null($template) && !empty($template))
                $this->appendKeyValueData($store, "template", $template);
        }
        
        protected function writeVoiceMessageData($vmc, &$store){
            // message properties
            $this->writeVoiceMessageProperties($vmc, $store);
            $this->writeCommonMessageProperties($vmc, $store);
            
            // message destinations
            $this->writeDestinations($vmc, $store);
        }
        
        protected function writeCommonMessageProperties($mc, &$store) {
            if (is_null($mc))
                throw new \Exception('Invalid object reference for writing common message properties.');
            
            // if message is to be scheduled
            if ($mc instanceof MessageComposer && $mc->schedule()){
                $scheduleInfo = $mc->getScheduleInfo();
                $this->writeScheduleInfoData($scheduleInfo[0], $scheduleInfo[1], $store);
            }
            
            // if delivery notifications are requested
            if ($mc->notifyDeliveries()){
                $notifyInfo = $mc->getNotifyURLInfo();
                $this->writeNotifyInfoData($notifyInfo[0], $notifyInfo[1], $store);
            }
        }
        
        protected function writeScheduleInfoData($dateTime, $utcOffset, &$store) {
            // validate
            $this->validateScheduleInfo($dateTime, $utcOffset);
            
            // append data
            $this->appendKeyValueData($store, "schedule", MessageUtil::dateTimeToStr($dateTime));
            
            // if utc offset is provided we write it
            if (!is_null($utcOffset) && !empty($utcOffset))
                $this->appendKeyValueData ($store, "utcOffset", $utcOffset);
        }
        
        protected function writeNotifyInfoData($url, $contentType, &$store) {
            // validate
            $this->validateDeliveryNotificationInfo($url, $contentType);
            
            // append data
            $this->appendKeyValueData($store, "notifyUrl", $url);
            $this->appendKeyValueData($store, "notifyAccept", RequestUtil::getDataContentTypeLabel($contentType));
        }
        
        protected function writeDestinations($mc, &$store) {
            if ($mc == null || $mc instanceof Composer === false)
                throw new \Exception('Invalid object reference for writing message destinations.');
            
            // get destinations
            $compDestsList = $mc->getDestinations();
            
            if ($compDestsList->getCount() == 0)
                throw new \Exception('There are no items to write message destinations.');
            
            $destsStr = "";
            $valuesStr = "";
            
            foreach ($compDestsList as $compDest){
                if ($compDest->getWriteMode() == DestinationMode::DM_NONE)
                    continue;
                
                $phoneNumber = $compDest->getPhoneNumber();
                
                // validate destination sender Id
                if ($mc instanceof MessageComposer)
                    $mc->validateDestinationSenderName($phoneNumber);
                
                // other data
                $messageId = $compDest->getMessageId();
                $destData  = $compDest->getData();
                $tempDestsStr = $phoneNumber;
                
                if (!is_null($messageId) && !empty($messageId))
                    $tempDestsStr .= "@{$messageId}";
                    
                if (!is_null($destData) && $destData instanceof PersonalisedValues){
                    $valStr = $this->getPersonalisedValuesStr($destData);
                    
                    // append to the personalised values string
                    $valuesStr .= (empty($valuesStr) ? "" : self::PSND_VALUES_GRP_SEP).$valStr;
                }
                
                // update destinations str
                $destsStr .= (empty($destsStr) ? "" : self::DESTINATIONS_SEPARATOR).$tempDestsStr;
            }
            
            // append destinations
            $this->appendKeyValueData($store, "to", $destsStr);
            
            // if there are personalised values, append them too
            if (!empty($valuesStr))
                $this->appendKeyValueData ($store, "values", $valuesStr);
        }
        
        private function getPersonalisedValuesStr($pv){
            $valStr = "";
            
            foreach ($pv->export() as $value)
                $valStr .= (empty($valStr) ? "" : self::PSND_VALUES_UNIT_SEP).$value;
            
            // return values
            return $valStr;
        }
        
        public function &writeDestinationsDeliveryRequest($templateId, $messageIdsArr) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message reference for writing destinations delivery request.');
            
            // message Ids
            if (is_null($messageIdsArr) || !is_array($messageIdsArr) || count($messageIdsArr) == 0)
                throw new \Exception('Invalid reference to list for writing destinations delivery request.');
            
            $store = &$this->_keyValueArr;
            $idsStr = "";
            
        //    $this->writeAuthData($store);
            $this->writeMessageReferenceId($templateId, $store);
            
            foreach ($messageIdsArr as $messageId)
                $idsStr .= (empty($idsStr) ? "" : self::DESTINATIONS_SEPARATOR).$messageId;
            
            // append message Ids
            $this->appendKeyValueData($store, "to", $idsStr);
            
            // return request body string
            return $this->prepareRequestData();
        }
        
        public function &writeDestinationsData($mc) {
            if (is_null($mc) || $mc instanceof Composer === false)
                throw new \Exception('Invalid object reference for writing message destinations data.');

            $this->writeDestinations($mc, $this->_keyValueArr);
            
            // return it
            return $this->prepareRequestData();
        }
        
        public function &writeScheduledMessagesLoadRequest($filter) {
            // perform validation
            $this->validateScheduledMessagesLoadData($filter);
            
            $store = &$this->_keyValueArr;

            // message category to load
            if (!is_null($filter['category'])){
                $this->appendKeyValueData($store, "category", $filter['category']);
            }
            
            // date specifications
            if (!is_null($filter['dateFrom']) && !is_null($filter['dateTo'])){
                $dateFromStr = MessageUtil::dateTimeToStr($filter['dateFrom']);
                $dateToStr   = MessageUtil::dateTimeToStr($filter['dateTo']);
                
                $this->appendKeyValueData($store, "from", $dateFromStr);
                $this->appendKeyValueData($store, "to", $dateToStr);
                
                // if there is UTC offset append it
                if (!is_null($filter['utcOffset']) || !empty($filter['utcOffset']))
                    $this->appendKeyValueData($store, "utcOffset", $filter['utcOffset']);
            }
            
            // reutrn request body string
            return $this->prepareRequestData();
        }
        
        public function &writeScheduledMessageUpdateRequest($mc) {
            if (is_null($mc) || $mc instanceof Composer)
                throw new \Exception('Invalid object reference for writing scheduled message update request.');
            
            $store = &$this->_keyValueArr;
            $category = $mc->getCategory();
            
            // append template Id
            $this->writeMessageReferenceId($mc->getReference(), $store);
            
            // properties to be written will depend on the message category
            if ($category == MessageCategory::MC_SMS || $category == MessageCategory::MC_USSD)
                $this->writeSMSProperties($mc, $store);
            else
                $this->writeVoiceMessageProperties($mc, $store);
            
            // write and append message destinations if any
            if ($mc->getDestinationsCount() > 0)
                $this->writeScheduledMessageDestinations($mc, $store);
            
            // return request string
            return $this->prepareRequestData();
        }
        
        private function writeScheduledMessageDestinations(MessageComposer $mc, &$store){
            $compDestsList = $mc->getDestinations();
            
            if (is_null($compDestsList) || $compDestsList->getCount() == 0)
                return;
            
            $addDestStr = "";
            $addValuesStr = "";
            $updateDestStr = "";
            $updateValuesStr = "";
            $deleteDestStr = "";
            
            foreach ($compDestsList as $compDest){
                $destMode = $compDest->getWriteMode();
                
                // interested in destinations that have been added, updated, or to be deleted
                if ($destMode == DestinationMode::DM_NONE)
                    continue;
                
                $phoneNumber = $compDest->getPhoneNumber();
                $mc->validateDestinationSenderName($phoneNumber);
                
                // other data
                $destData = $compDest->getData();
                $messageId = $compDest->getMessageId();
                
                switch ($destMode){
                    case DestinationMode::DM_ADD:
                        $tempStr = $phoneNumber.(!is_null($messageId) && !empty($messageId) ? "@{$messageId}" : "");
                        $addDestStr .= (empty($addDestStr) ? "" : self::DESTINATIONS_SEPARATOR).$tempStr;
                        
                        // check for personalised values
                        if (!is_null($destData) && $destData instanceof PersonalisedValues){
                            $valStr = $this->getPersonalisedValuesStr($destData);
                            
                            // append
                            $addValuesStr .= (empty($addValuesStr) ? "" : self::PSND_VALUES_GRP_SEP).$valStr;
                        }
                        break;
                    
                    case DestinationMode::DM_UPDATE:
                        // the update can be phone number or in the case of text messages, the personalised values.
                        // So here the main key will be the message id
                        $updateDestStr .= (empty($updateDestStr) ? "" : self::DESTINATIONS_SEPARATOR)."{$messageId}@{$phoneNumber}";
                        
                        // check for personalised values
                        if (!is_null($destData) && $destData instanceof PersonalisedValues){
                            $valStr = $this->getPersonalisedValuesStr($destData);
                            
                            // append
                            $updateValuesStr .= (empty($updateValuesStr) ? "" : self::PSND_VALUES_GRP_SEP).$valStr;
                        }
                        break;
                    
                    case DestinationMode::DM_DELETE:
                        if (!is_null($messageId) && !empty($messageId))
                            $deleteDestStr .= (empty($deleteDestStr) ? "" : self::DESTINATIONS_SEPARATOR).$messageId;
                        break;
                }
            }
            
            // update those with data
            if (!empty($addDestStr)) {
                $this->appendKeyValueData($store, "to-add", $addDestStr);
                
                if (!empty($addValuesStr))
                    $this->appendKeyValueData($store, "values-add", $addValuesStr);
            }
            
            if (!empty($updateDestStr)){
                $this->appendKeyValueData($store, "to-update", $updateDestStr);
                
                if (!empty($updateValuesStr))
                    $this->appendKeyValueData ($store, "values-update", $updateValuesStr);
            }
            
            if (!empty($deleteDestStr))
                $this->appendKeyValueData($store, "to-delete", $deleteDestStr);
        }
        
        public function writeUSSDRequest($ucArr) {
            
        }
        
        private function writeUSSDData($tmc, &$store){
            // in future implementation
        }
        
        private function &writeTemplateIdArgumentRequest($templateId){
            $store = &$this->_keyValueArr;
        //    $this->writeAuthData($store);
            
            // append template id
            $this->writeMessageReferenceId($templateId, $store);
            
            // return request string
            return $this->prepareRequestData();
        }
        
        public function &writeScheduledMessageDestinationsLoadRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message template identifier for writing scheduled destinations load request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeCancelScheduleRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message reference for writing scheduled message cancel request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeDispatchScheduledMessageRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message template identifier for dispatching scheduled message.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
        
        public function &writeMessageDeliveryRequest($templateId) {
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid message template identifier for writing message delivery request.');
            
            return $this->writeTemplateIdArgumentRequest($templateId);
        }
      /*  
        public function &writeCreditBalanceRequest() {
            // content is the same for authrequest
            return $this->writeAuthRequest();
        }
        */
        private function writeMessageReferenceId($reference, &$store){
            $this->appendKeyValueData($store, "reference", $reference);
        }
        
        protected function &prepareRequestData(){
            $requestDataArr = array('keyValues'=> $this->_keyValueArr);
            
            // return it
            return $requestDataArr;
        }
        
        protected function appendKeyValueData(&$store, $key, $value) {
            $store[$key] = $value;
        }
    }