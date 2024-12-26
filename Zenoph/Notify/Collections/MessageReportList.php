<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Collections;
    
    use Zenoph\Notify\Store\MessageReport;
    use Zenoph\Notify\Collections\ObjectStorage;
    
    class MessageReportList implements \Iterator{
        private $_reportsList;
        
        public function __construct() {
            $this->_reportsList = new ObjectStorage();
        }
        
        public function addItem($item){
            if (is_null($item) || $item instanceof MessageReport === false)
                throw new \Exception('Invalid object type for adding message report item.');
            
            // add to the collection
            $this->_reportsList->attach($item);
        }
        
        public function &getItems(){
            return $this->_reportsList->getItems();
        }
        
        public function getItem($idx){
            if (is_null($idx) || !is_numeric($idx))
                throw new \Exception('Invalid item index.');
            
            if ($idx < 0 || $idx > $this->getCount())
                throw new \Exception('Index is out of range for list item.');
            
            $items = &$this->getItems();
            
            if (count($items) > 0)
                return $items[0];
            
            return null;
        }
        
        public function getCount(){
            return $this->_reportsList->getCount();
        }
        
        public function current() {
            return $this->_reportsList->current();
        }
        
        public function next() {
            return $this->_reportsList->next();
        }
        
        public function key() {
            return $this->_reportsList->key();
        }
        
        public function rewind() {
            $this->_reportsList->rewind();
        }
        
        public function valid() {
            return $this->_reportsList->valid();
        }
    }