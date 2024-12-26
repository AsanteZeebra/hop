<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Build\Reader;
    
    use Zenoph\Notify\Store\PersonalisedValues;
    use Zenoph\Notify\Store\MessageDestination;
    
    class MessageDestinationsReader {
        private $_done = false;
        private $_xmlReader = null;
        
        const __DESTINATIONS_FRAGMENT__ = "<destinations>(<item>.+</item>)+</destinations>";
        
        public function __construct() {
            
        }
        
        public function setData(&$data){
            if (is_null($data) || (!is_string($data) && $data instanceof \XMLReader == false))
                throw new \Exception('Invalid data reference for reading message destinations.');
            
            if ($data instanceof \XMLReader){
                $this->_xmlReader = $data;
            }
            else {
                // string data. validate and create reader for it
                $this->validateData($data);
                $this->_xmlReader = new \XMLReader();
                $this->_xmlReader->XML($data);
            }
        }
        
        public function getNextItem(){
            if (is_null($this->_xmlReader))
                throw new \Exception('Invalid reference to reader for reading next destination item.');
            
            while ($this->_xmlReader->read() && !$this->_done){
                $nodeType = $this->_xmlReader->nodeType;
                
                switch ($nodeType){
                    case \XMLReader::ELEMENT:
                        if (strtolower($this->_xmlReader->name) == "item"){
                            $itemXml = $this->_xmlReader->readOuterXml();
                            
                            // read and return the destination info
                            return $this->readDestinationItem($itemXml);
                        }
                        break;
                    
                    case \XMLReader::END_ELEMENT:
                        if (strtolower($this->_xmlReader->name) == "destinations"){
                            // we are at the end of the destinations element. 
                            // No more destination items to read
                            $this->_done = true;
                            
                            // exit the iteration
                            break;
                        }
                        break;
                }
            }
            
            // return nothing
            return null;
        }
        
        private function readDestinationItem($itemXmlStr){
            // We can us SimpleXML for this since $itemXml is not huge
            $xml = new \SimpleXMLElement($itemXmlStr);
            $destInfo = array();
            
            // read indivual details needed
            if (isset($xml->to))
                $destInfo['phoneNumber'] = (string)$xml->to;
            
            // country
            if (isset($xml->country))
                $destInfo['country'] = (string)$xml->country;
            
            // message Id,
            if (isset($xml->messageId))
                $destInfo['messageId'] = (string)$xml->messageId;
            
            // message text
            if (isset($xml->message))
                $destInfo['message'] = (string)$xml->message;
            
            // destination status
            if (isset($xml->status) && isset($xml->status->id))
                $destInfo['statusId'] = (int)$xml->status->id;
            
            // destination validation
            if (isset($xml->validation) && isset($xml->validation->id))
                $destInfo['destValidation'] = (int)$xml->validation->id;
            
            // message count
            if (isset($xml->messageCount))
                $destInfo['messageCount'] = (int)$xml->messageCount;
            
            // submit date time
            if (isset($xml->submitDateTime))
                $destInfo['submitDateTime'] = (string)$xml->submitDateTime;
            
            // report date time
            if (isset($xml->reportDateTime))
                $destInfo['reportDateTime'] = (string)$xml->reportDateTime;
            
            // In the case of personalised SMS, there can be values when scheduled message is loaded
            if (isset($xml->values->value)){
                $valuesArr = array();
                
                for ($i = 0; $i < count($xml->values->value); $i++)
                    $valuesArr[] = (string)$xml->values->value[$i];
                
                // create personalised values object and set
                $psndValues = new PersonalisedValues($valuesArr);
                $destInfo['psndValues'] = $psndValues;
            }
            
            if (count($destInfo) > 0)
                return MessageDestination::create($destInfo);
            
            return null;
        }
        
        private function validateData(&$data){
            $pattern = "/".self::__DESTINATIONS_FRAGMENT__."/";
        /*    
            if (!preg_match($pattern, $data))
                throw new \Exception('Destinations data is not in the correct format.'); */
        }
    }