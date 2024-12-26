<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    class ObjectStorage implements \Iterator {
        private $_store = null;
        
        public function __construct() {
            $this->_store = array();
        }
        
        public function attach($object){
            // get a unique identifier for the object
            $hashKey = $this->computeObjectHash($object);
            
            // check to see if this hash exists or not
            if (array_key_exists($hashKey, $this->_store))
                throw new \Exception("Object already exists in the objects store.");
            
            // include in the collection
            $this->_store[$hashKey] = $object;
        }
        
        public function contains($object){
            if (is_null($object))
                throw new \Exception('Invalid reference for verifying object existence.');
            
            // compute the hash and check to see if it exists or not
            $hashKey = $this->computeObjectHash($object);
            
            // check and return existence
            return array_key_exists($hashKey, $this->_store);
        }
        
        public function detach($object){
            if (is_null($object))
                throw new \Exception('Invalid reference for detaching from objects store.');
            
            // it should exist
            $hashKey = $this->computeObjectHash($object);
            
            // if it exists remove it
            if (array_key_exists($hashKey, $this->_store)) {
                unset($this->_store[$hashKey]);
                return true;
            }
            
            return false;
        }
        
        public function getCount(){
            return count($this->_store);
        }
        
        public function &getItems(){
            $values = array_values($this->_store);
            return $values;
        }
        
        public function clear(){
            if (count($this->_store) > 0){
                unset($this->_store);
                $this->_store = array();
            }
        }
        
        private function computeObjectHash($object){
            return spl_object_hash($object);
        }
        
        public function current() {
            return current($this->_store);
        }
        
        public function next() {
            return next($this->_store);
        }
        
        public function key() {
            return key($this->_store);
        }
        
        public function rewind() {
            reset($this->_store);
        }
        
        public function valid(){
            return isset($this->_store[key($this->_store)]);
        }
    }