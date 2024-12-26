<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    class RequestException extends \Exception {
        private $_handShake = null;
        
        public function __construct($message = "", $handShake = 0, $previous = null) {
            parent::__construct($message, 0, $previous);
            $this->_handShake = $handShake;
        }
        
        public function getRequestHandshake(){
            return $this->_handShake;
        }
    }