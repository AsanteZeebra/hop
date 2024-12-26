<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Response;
    
    class CreditBalanceResponse extends APIResponse {
        private $_balance = null;
        private $_currencyName = null;
        private $_currencyCode = null;
        private $_isCurrencyPriced = false;
        
        protected function __construct() {
            parent::__construct();
        }
        
        public static function create(&$apiResponse){
            $dataFragment = &$apiResponse->getDataFragment();
            
            $cbr = new CreditBalanceResponse();
            $cbr->_httpStatusCode = $apiResponse->getHttpStatusCode();
            $cbr->_requestHandShake = $apiResponse->getRequestHandshake();
            
            // extract the balance information
            $balanceInfo = self::extractBalanceInfo($dataFragment);
            $cbr->_balance = $balanceInfo['balance'];
            $cbr->_currencyName = $balanceInfo['currencyName'];
            $cbr->_currencyCode = $balanceInfo['currencyCode'];
            $cbr->_isCurrencyPriced = $balanceInfo['currencyPriced'];
            
            // return the balance response object
            return $cbr;
        }
        
        private static function extractBalanceInfo(&$data){
            $xml = simplexml_load_string($data);
            
            $balanceInfo['balance'] = (float)$xml->balance->amount;
            $balanceInfo['currencyName'] = (string)$xml->balance->currencyName;
            $balanceInfo['currencyCode'] = (string)$xml->balance->currencyCode;
            $balanceInfo['currencyPriced'] = ((string)$xml->balance->currencyPriced) === 'true';
            
            // return extracted balance details
            return $balanceInfo;
        }
        
        public function getBalance(){
            return $this->_balance;
        }
        
        public function getCurrencyName(){
            return $this->_currencyName;
        }
        
        public function getCurrencyCode(){
            return $this->_currencyCode;
        }
        
        public function isCurrencyPriced(){
            return $this->_isCurrencyPriced;
        }
    }