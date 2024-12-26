<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Store\AuthProfile;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Enums\MessageCategory;
    use Zenoph\Notify\Enums\DataContentType;
    use Zenoph\Notify\Response\MessageResponse;
    use Zenoph\Notify\Compose\MessageComposer;
    use Zenoph\Notify\Compose\SMSComposer;
    use Zenoph\Notify\Build\Reader\MessagePropertiesReader;
    
    class ScheduledMessageRequest extends NotifyRequest {
        private $_fromDateTime = null;
        private $_toDateTime = null;
        private $_category = null;
        private $_utcOffset = null;
        private $_templateId = null;
        private static $_baseResource;
        
        public function __construct($authProfile = null) {
            if (is_null($authProfile))
                throw new \Exception('Authentication profile parameter not set for scheduled messages request.');
            
            // it should be an instance of auth profile and authenticated
            if ($authProfile instanceof AuthProfile == false)
                throw new \Exception('Invalid reference to authentication profile object.');
            
            // it should already be authenticated
            if (!$authProfile->authenticated())
                throw new \Exception('Authentication profile has not been verified.');
            
            parent::__construct($authProfile);
            $this->_category = MessageCategory::MC_SMS;    // by default
        }
        
        public static function initShared(){
            self::$_baseResource = 'message/scheduled';
        }
        
        private function validateDates(){
            if ($this->_fromDateTime != null && $this->_toDateTime == null)
                throw new \Exception("'From Date' has not been set for scheduled message request.");
            
            if ($this->_fromDateTime == null && $this->_toDateTime != null)
                throw new \Exception("'To Date' has not been set for scheduled message request.");
        }
        
        private function prepareScheduledLoadParams(){
            $data = array('category'=> $this->_category,
                    'dateFrom'=>$this->_fromDateTime,
                    'dateTo'=>$this->_toDateTime,
                    'utcOffset'=>$this->_utcOffset,
                    'templateId'=>$this->_templateId
                );
            
            return $data;
        }
        
        private function loadScheduled(){
            // at least category should be specified
            if (is_null($this->_category))
                throw new \Exception('Message category has not been set for loading scheduled messages.');
            
            $this->setRequestResource(self::$_baseResource.'/load');
            $this->setResponseContentType(DataContentType::DCT_GZBIN_XML);
            
            // initialise request writing
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeScheduledMessagesLoadRequest($this->prepareScheduledLoadParams());
            
            // submit for response
            $apiResponse = parent::submit();
            
            // create messages
            return $this->createMessages($apiResponse->getDataFragment());
        }
        
        public function loadMessages($category, $dateFrom = null, $dateTo = null, $utcOffset = null){
            if (is_null($category) || !MessageCategory::isDefined($category))
                throw new \Exception('Invalid message category identifier.');
            
            $this->_category = $category;
            
            // not for a single message so $messageId must be set to nothing
            $this->_templateId = null;
            $this->_utcOffset = null;
            
            // We don't expect one dateTime to be set while the other is not
            if ((is_null($dateFrom) && !is_null($dateTo)) || (!is_null($dateFrom) && is_null($dateTo)))
                throw new \Exception('Invalid date time specifiers for loading scheduled messages.');
            
            if (!is_null($dateFrom) || !is_null($dateTo)){
                // Provided parameters must be instances of DateTime
                if (!($dateFrom instanceof \DateTime) || !($dateTo instanceof \DateTime))
                    throw new \Exception('Invalid date time specifiers for loading scheduled messages.');
            }
            
            // If UTC offset provided, validate and set it
            if (!is_null($utcOffset) && !empty($utcOffset)){
                if (!MessageUtil::isValidTimeZoneOffset($utcOffset))
                    throw new \Exception('Invalid UTC offset for loading scheduled messages.');
                
                // set the time zone utc offset
                $this->_utcOffset = $utcOffset;
            }
            
            $this->_fromDateTime = $dateFrom;
            $this->_toDateTime  = $dateTo;
            
            // validate the dates
            $this->validateDates();
            
            // load and return messages.
            return $this->loadScheduled();
        }
        
        public function loadMessage($templateId){
            if (is_null($templateId) || empty($templateId))
                throw new \Exception('Invalid identifier for loading scheduled message.');
            
            // For specified message, category and date definitions are not required
            $this->_fromDateTime = $this->_toDateTime = null;
            
            // Set the mssage id
            $this->_templateId = $templateId;
            
            // Prepare request and submit for response, then extract message details.
            $scheduledList = $this->loadScheduled();
            
            if (is_null($scheduledList) || $scheduledList->getCount() == 0)
                return null;

            // There is only one item
            return $scheduledList->getItem(0);
        }
     
        private function createMessages(&$dataFragment){ 
            $messagesArr = null;
            
            // If the data fragment is empty, then there are no scheduled messages
            if (is_null($dataFragment) || empty($dataFragment))
                return $messagesArr;
            
            $msgPropsReader = new MessagePropertiesReader();
            $msgPropsReader->setDataFragment($dataFragment);
            $msgPropsReader->isScheduled(true);
            
            if (!is_null($this->_authProfile))
                $msgPropsReader->setAuthProfile($this->_authProfile);
            
            // get and return the messages collection
            return $msgPropsReader->getMessages();
        }
        
        public function loadDestinations($mc){
            if (is_null($mc) || !($mc instanceof Composer))
                throw new \Exception('Invalid reference to Message object for loading destinations.');
            
            if ($mc instanceof SMSComposer){
                $messageText = $mc->getMessage();
                
                if (is_null($messageText) || empty($messageText))
                    throw new \Exception('Message properties have not been loaded for loading destinations.');
            }
            
            // Set request parameters
            $this->setRequestResource(self::$_baseResource.'/destinations/load');
            $this->setResponseContentType(DataContentType::DCT_GZBIN_XML);
            
            // initialise request writing
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeScheduledMessageDestinationsLoadRequest($mc->getTemplateId());
            
            // submit for response
            $apiResponse = $this->submit();
            return MessageComposer::populateScheduledDestinations($mc, $apiResponse->getDataFragment());
        }
        
        public function cancelSchedule($mc){
            if (is_null($mc) || $mc instanceof Composer == false)
                throw new \Exception('Invalid message object reference for cancelling message scheduling.');
            
            // message should be scheduled
            if (!$mc->isScheduled())
                throw new \Exception('The message has not been scheduled for cancelling.');
            
            $this->setRequestResource(self::$_baseResource.'/cancel');
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeCancelScheduleRequest($mc->getReference());
            
            // submit response
            return $this->submit();
        }
        
        public function dispatchMessage($mc){
            if (is_null($mc) || $mc instanceof Composer == false)
                throw new \Exception('Invalid object reference for dispatching scheduled message.');
            
            // message should be a scheduled one
            if (!$mc->isScheduled())
                throw new \Exception('The message has not been scheduled for dispatch.');
            
            // begin request
            $this->setRequestResource(self::$_baseResource.'/dispatch');
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeDispatchScheduledMessageRequest($mc->getReference());
            
            // submit and return response
            return $this->submit();
        }
        
        public function updateMessage($mc){
            if (is_null($mc) || $mc instanceof Composer == false)
                throw new \Exception('Invalid reference to message composer object.');
            
            $this->setRequestResource(self::$_baseResource.'/update');
            $this->setResponseContentType(DataContentType::DCT_GZBIN_XML);
            
            // init request writing
            $this->initRequest();
            $dataWriter = $this->createDataWriter();
            $this->_requestData = &$dataWriter->writeScheduledMessageUpdateRequest($mc);
            
            // submit for response
            $apiResponse = $this->submit();
            $msgResponse = MessageResponse::create($apiResponse);
            $msgReportList = $msgResponse->getReports();
            
            // there will be only one message item
            $msgReport = $msgReportList->getItem(0);
            $msgDestsList = $msgReport->getDestinations();
            
            // if new destinations were added, write mode should be refreshed
            if (!is_null($msgDestsList) && $msgDestsList->getCount() > 0)
                $mc->refreshScheduledDestinationsUpdate($msgDestsList);
            
            // return message response
            return $msgResponse;
        }
    }
    
    ScheduledMessageRequest::initShared();