<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    use Zenoph\Notify\Collections\IDataList;
    
    abstract class DataList implements IDataList, \Iterator {
        private $_dataArray = null;
        private $_key = 0;
        
        public function __construct(&$dataArray) {
            if (is_null($dataArray) || !is_array($dataArray))
                throw new \Exception("Invalid data for creating collection.");
            
            $this->_dataArray = &$dataArray;
            $this->_key = 0;
        }
        
        public function next() {
            $this->_key++;
        }
        
        public function current() {
            return $this->_dataArray[$this->_key];
        }
        
        public function key() {
            return $this->_key;
        }
        
        public function rewind() {
            $this->_key = 0;
        }
        
        public function valid() {
            return isset($this->_dataArray[$this->_key]);
        }
    }