<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    use Zenoph\Notify\Compose\MessageComposer;
    
    class MessageComposerList implements \Iterator {
        private $_messagesList;
        private $_pointer = 0;
        
        public function __construct() {
            $this->_messagesList = array();
        }
        
        public function addItem($item){
            // it should be a message composer object
            if (is_null($item) || $item instanceof MessageComposer == false)
                throw new \Exception('Invalid object reference for item to message composer collection.');
            
            // add to collection
            $this->_messagesList[] = $item;
        }
        
        public function getItem($idx){
            if (is_null($idx) || !is_numeric($idx))
                throw new \Exception('Invalid valid for message composer item.');
            
            if ($idx < 0 || $idx > count($this->_messagesList))
                throw new \Exception('Index is out of range for message composer item.');
            
            return $this->_messagesList[$idx];
        }
        
        public function getCount(){
            return count($this->_messagesList);
        }
        
        public function current() {
            return $this->_messagesList[$this->_pointer];
        }
        
        public function next() {
            $this->_pointer++;
        }
        
        public function key() {
            return $this->_pointer;
        }
        
        public function rewind() {
            $this->_pointer = 0;
        }
        
        public function valid() {
            return count($this->_messagesList) > 0 && 
                isset($this->_messagesList[$this->_pointer]);
        }
    }