<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Response;
    
    use Zenoph\Notify\Enums\DataContentType;
    use Zenoph\Notify\Enums\RequestHandshake;
    use Zenoph\Notify\Utils\RequestUtil;
    use Zenoph\Notify\Request\RequestException;
    
    class APIResponse {
        protected $_httpStatusCode = 0;
        protected $_dataFragment = "";
        protected $_requestHandShake = RequestHandshake::HSHK_ERR_UNKNOWN;
        
        private static $_responsePattern = "<response><handshake>.+<\/handshake>(<data>(.*)<\/data>)?<\/response>";
        
        protected function __construct() {
            $this->_httpStatusCode = 0;
        }
        
        public static function create(&$param){
            $httpStatusCode = $param[0];
            $contentTypeLabel = $param[1];
            $responseData = &$param[2];
            
            // ensure we have a supported content type
            if (!RequestUtil::isValidContentTypeLabel($contentTypeLabel))
                throw new \Exception('Unknown response content type label.');
            
            // get the enum type
            $contentType = RequestUtil::getDataContentTypeFromLabel($contentTypeLabel);
            
            if ($contentType == DataContentType::DCT_GZBIN_XML || $contentType == DataContentType::DCT_GZBIN_JSON){
                $responseData = &RequestUtil::decompressData($responseData);
                
                if (is_null($responseData))
                    throw new \Exception("Invalid response data for submitted request.");
            }
            
            $responseObj = new APIResponse();
            $responseObj->initResponse($httpStatusCode, $responseData);
            return $responseObj;
        }
        
        public function &getDataFragment(){
            return $this->_dataFragment;
        }
        
        public function getHttpStatusCode(){
            return $this->_httpStatusCode;
        }
        
        public function getRequestHandShake(){
            return $this->_requestHandShake;
        }
        
        private function initResponse($statusCode, &$responseStr){
            if (is_null($statusCode) || !is_numeric($statusCode))
                throw new \Exception('Invalid response status code.');
            
            // Ensure we have a valid API response text stream
            if (!$this->isValidAPIResponse($responseStr))
                throw new \Exception('Unknown response was received from the server.');
            
            // Set HTTP status code and extract data, if any
            $this->_httpStatusCode = $statusCode;
            $this->extractData($responseStr);
            $this->assertRequestHandShake();
        }
        
        private function assertRequestHandShake(){
            if ($this->_requestHandShake != RequestHandshake::HSHK_OK){
                $errStr = "Request handshake failure!";
                
                switch ($this->_requestHandShake){
                    case RequestHandshake::HSHK_ERR_RH_CONTENT_TYPE:
                        throw new RequestException("{$errStr} Missing or invalid request content type.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_RH_HTTP_ACCEPT:
                        throw new RequestException("{$errStr} Missing or invalid response content type.", $this->_requestHandShake);
                        
                    // GROUP ID: 12
                    case RequestHandshake::HSHK_ERR_UA_AUTH:
                        throw new RequestException("{$errStr} User authentication failed.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_UA_MODEL:
                        throw new RequestException("{$errStr} Missing or invalid authentication model.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_UA_PID:
                        throw new RequestException("{$errStr} Missing or invalid authentication PID.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_UA_API_NO_ACCESS:
                        throw new RequestException("{$errStr} API access is disabled in your account.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_UA_API_NO_PPASS:
                        throw new RequestException("{$errStr} Portal authentication factor is disabled over API calls.", $this->_requestHandShake);
                        
                    // Unable to understand request. GROUP_ID 14
                    case RequestHandshake::HSHK_ERR_DATA:
                        throw new RequestException("{$errStr} Missing request data.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_BAD_REQUEST:
                        throw new RequestException("{$errStr} Bad request.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_INTERNAL:
                        throw new RequestException("{$errStr} Internal server error.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_ACCESS_DENIED:
                        throw new RequestException("{$errStr} Access denied for request.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_API_RETIRED:
                        throw new RequestException("{$errStr} The API version for the request has been retired.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SERVICE:
                        throw new RequestException("{$errStr} Service request not granted.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_ACCT_INACTIVE:
                        throw new RequestException("{$errStr} Account is currently inactive.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_ACCT_SUSPENDED:
                        throw new RequestException("{$errStr} Account is currently suspended.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_IDEMPOTENCY_KEY:
                        throw new RequestException("{$errStr} Invalid request idempotency key.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_API_VERSION:
                        throw new RequestException("{$errStr} Missing or invalid request API version.", $this->_requestHandShake);
                        
                        
                    // GROUP ID: 18 (for scheduled messages requests)
                    case RequestHandshake::HSHK_ERR_SM_PROCESSED:
                        throw new RequestException("{$errStr} The scheduled message is already processed.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_NOT_SCHEDULED:
                        throw new RequestException("{$errStr} The specified message was not scheduled.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_CATEGORY:
                        throw new RequestException("{$errStr} Missing or invalid scheduled messages category.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_DATETIME:
                        throw new RequestException("{$errStr} Missing or invalid date and time filters for loading scheduled messages.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_CANCELLED:
                        throw new RequestException("{$errStr} Scheduled message was cancelled.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_REFERENCE_ID:
                        throw new RequestException("{$errStr} Missing or invalid scheduled message reference identifier.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_MESSAGE_ID:
                        throw new RequestException("{$errStr} Missing or invalid scheduled message identifier.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_SM_TZ_OFFSET:
                        throw new RequestException("{$errStr} Invalid scheduled message timezone offset.", $this->_requestHandShake);
                        
                    // GROUP ID: 15
                    case RequestHandshake::HSHK_ERR_MR_REFERENCE_ID:
                        throw new RequestException("{$errStr} Missing or invalid message template identifier for request.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_DESTINATIONS:
                        throw new RequestException("{$errStr} Invalid message destinations parameter.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_PARAMETER:
                        throw new RequestException("{$errStr} Missing or invalid request parameter.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_QUERY_TIME:
                        throw new RequestException("{$errStr} Message request time.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_VOICE_FILE:
                        throw new RequestException("{$errStr} Missing or invalid voice message file.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_VOICE_SIZE:
                        throw new RequestException("{$errStr} Voice message file size limit exceeded.", $this->_requestHandShake);
                    case RequestHandshake::HSHK_ERR_MR_STATUS_FILTER:
                        throw new RequestException("{$errStr} Missing or invalid message status filter.", $this->_requestHandShake);
            /*            
                    // Delivery requests. GROUP_ID: 15
                    case RequestHandShake::HSHK_ERR_DR_DESTINATION_ID:
                        throw new RequestException("{$errStr}: Missing or invalid destination identifier.", $this->requestHandShake);
                    case RequestHandShake::HSHK_ERR_DR_MESSAGE_ID:
                        throw new RequestException("{$errStr}: Missing or invalid message identifier.", $this->requestHandShake); */

                        
                        
                        
                    case RequestHandshake::HSHK_ERR_UNKNOWN:
                    default:
                        throw new RequestException("{$errStr} Unknown request handshake error.", $this->_requestHandShake);
                }
            }
        }
        
        private function isValidAPIResponse(&$fragment){
            // check if fragment matches response pattern
            $matches = array();
            $pattern = "/".self::$_responsePattern."/s";
 
            preg_match($pattern, $fragment, $matches);            
            return count($matches) > 0;
        }
        
        private function extractData(&$responseStr){
            // Use Regex to extract the response. It is in XML
            $matches = array();
            $pattern = "/".self::$_responsePattern."/s";
            preg_match($pattern, $responseStr, $matches);
            
            // We expect 1 match
            if (count($matches) == 0)
                throw new \Exception('Missing response data or invalid response data format.');
            
            $responseStr = &$matches[0];
            $handShakeDone = false;
            $dataDone = false;
            
            // The response can be a large data. Use XMLReader for in-memory reading
            $xml = new \XMLReader();
            $xml->XML($responseStr);
            
            while ($xml->read()){
                if ($xml->nodeType == \XMLReader::ELEMENT && strtolower($xml->name) == 'handshake'){
                    $node = new \SimpleXMLElement($xml->readOuterXml());
                    $this->_requestHandShake = (int)$node->id;
                    $handShakeDone = true;
                    
                    if ($dataDone) {
                        $xml->close();
                        return;
                    }
                }
                else if ($xml->nodeType == \XMLReader::ELEMENT && strtolower($xml->name) == 'data'){
                    $this->_dataFragment = $xml->readOuterXml();
                    $dataDone = true;
                    
                    if ($handShakeDone) {
                        $xml->close();
                        return;
                    }
                }
            }
        }
    }
