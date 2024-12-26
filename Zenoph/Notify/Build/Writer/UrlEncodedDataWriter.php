<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Build\Writer;
    
    use Zenoph\Notify\Build\Writer\KeyValueDataWriter;
    
    class UrlEncodedDataWriter extends KeyValueDataWriter {
        public function __construct() {
            parent::__construct();
        }
        
        public function &writeVoiceRequest($vmcArr) {
            if (is_null($vmcArr) || !is_array($vmcArr) || count($vmcArr) == 0)
                throw new \Exception('Invalid data reference for writing voice message request.');
            
            if (count($vmcArr) > 1)
                throw new \Exception('There must be only one message object for writing key/value message request.');
            
            $vmc = $vmcArr[0];
            $store = &$this->_keyValueArr;
            
            // write the voice message data
            $this->writeVoiceMessageData($vmc, $store);
            
            // return request body
            return $this->prepareRequestData();
        }
    }