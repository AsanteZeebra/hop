<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Response;
    
    use Zenoph\Notify\Collections\MessageReportList;
    use Zenoph\Notify\Build\Reader\MessageReportReader;
    
    class MessageResponse extends APIResponse {
        protected $_reports = null;
        
        protected function __construct() {
            parent::__construct();
            $this->_reports = array();
        }
        
        public static function isValidDataFragment(&$fragment){
            $matches = array();
            preg_match("/<data>(<messages>(<message>(.*)<\/message>)+<\/messages>)?<\/data>/s", $fragment, $matches); 
           
            return count($matches) > 0;
        }
        
        public function getReports(){
            return $this->_reports;
        }
        
        public static function create(&$apiResponse){
            $dataFragment = &$apiResponse->getDataFragment();
            $msgResponse = new MessageResponse();
            
            $msgResponse->_httpStatusCode = $apiResponse->getHttpStatusCode();
            $msgResponse->_requestHandShake = $apiResponse->getRequestHandshake();
            
            if (!is_null($dataFragment) && !empty($dataFragment)){
                // Ensure response data fragment is correct
                if (!self::isValidDataFragment($dataFragment)){
                    throw new \Exception('Invalid response data fragment.');
                }

                // extract response details
                $msgResponse->_reports = self::extractMessages($dataFragment);
            }
            
            return $msgResponse;
        }
        
        protected static function &extractMessages(&$dataFragment){
            $reportReader = new MessageReportReader();
            $reportsList = new MessageReportList();
            
            $reportReader->setData($dataFragment);
            $done = false;
            
            do {
                $msgReport = $reportReader->getNextReport();
                
                if (is_null($msgReport))
                    break;
                    
                // add message report list
                    $reportsList->addItem($msgReport);
            } while (!$done);
            
            // return the reports list
            return $reportsList;
        }
    }