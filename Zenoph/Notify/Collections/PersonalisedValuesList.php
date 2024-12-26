<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    use Zenoph\Notify\Store\PersonalisedValues;
    
    class PersonalisedValuesList implements \Iterator{
        private $_valuesArr;
        private $_pointer;
        
        public function __construct() {
            $this->_valuesArr = array();
            $this->_pointer = 0;
        }
        
        public function addItem($item){
            if (is_null($item) || $item instanceof PersonalisedValues === false)
                throw new \Exception('Invalid object reference for adding to personalised values collection.');
            
            $this->_valuesArr[] = $item;
        }
        
        public function getCount(){
            return count($this->_valuesArr);
        }
        
        public function getItem($idx){
            if (is_null($idx) || !is_numeric($idx))
                throw new \Exception('Invalid value for getting personalised values item.');
            
            if ($idx < 0 || $idx > count($this->_valuesArr))
                throw new \Exception('Index is out of range for getting personalised values item.');
            
            return $this->_valuesArr[$idx];
        }
        
        public function current() {
        //    $currPv = $this->_valuesArr[$this->_pointer];
            
            return $this->_valuesArr[$this->_pointer];
         /*   
            // don't send the object. Export the string array
            return $currPv->export();*/
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
            return isset($this->_valuesArr[$this->_pointer]);
        }
    }