<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    abstract class IterableCollection implements \Iterator {
        private $_dataArr = array();
        private $_index = 0;
        
        public function __construct(&$dataArr = null){
            if (!is_null($dataArr) && is_array($dataArr))
                $this->_dataArr = &$dataArr;
            
            $this->_index = 0;
        }
        
        public function next() {
            $this->_index++;
        }
        
        public function current() {
            return $this->_dataArr[$this->_index];
        }
        
        public function key() {
            return $this->_index;
        }
        
        public function rewind() {
            $this->_index = 0;
        }
        
        public function valid(){
            return isset($this->_dataArr[$this->_index]);
        }
    }