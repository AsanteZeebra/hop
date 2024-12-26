<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Store;
    
    class PersonalisedValues implements \Iterator{
        private $_values = array();
        private $_index = 0;
        
        public function __construct(&$valuesArr) {
            if (is_null($valuesArr) || !is_array($valuesArr) || count($valuesArr) == 0)
                throw new \Exception("Invalid values for initialising personalised values data.");
            
            // get copy of it
            $this->_values = $valuesArr;
        }
        
        public function getSize(){
            return count($this->_values);
        }
        
        public function export(){
            return $this->_values;
        }
        
        public function next() {
            return $this->_index++;
        }
        
        public function current() {
            return $this->_values[$this->_index];
        }
        
        public function key(){
            return $this->_index;
        }
        
        public function rewind() {
            $this->_index = 0;
        }
        
        public function valid() {
            return isset($this->_values[$this->_index]);
        }
    }