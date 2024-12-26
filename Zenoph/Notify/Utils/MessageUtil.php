<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Utils;
    
    use Zenoph\Notify\Enums\TextMessageType;
    use Zenoph\Notify\Enums\MessageCategory;
    
    class MessageUtil {
        const PHONENUM_PATTERN = '\+?[0-9]{8,13}';  // taking notice of length of phone number
        const DATETIME_FORMAT = "Y-m-d H:i:s";
        const DATETIME_FORMAT_EX = "Y-m-d H:i:s T"; // inclusion of T to add time zone offset string
        const TZ_OFFSET_PATTERN = "/^(\+|-)(([0][0-9]:[0-5][0-9])|([1][0-2]:[0-5][0-9])|(13:00))$/";
        
        const __CUSTOM_MSGID_MIN_LEN__ = 30;
        const __CUSTOM_MSGID_MAX_LEN__ = 40;
        
        private static $messageTypes = null;
        private static $timeZones = null;
        
        public static function isValidTimeZoneOffset($offset){
            return preg_match(self::TZ_OFFSET_PATTERN, $offset);
        }
        
        public static function extractGeneralSettings(&$df){
            $xml = simplexml_load_string($df);
            
            // extract message types
            self::extractMessageTypes($xml);
            
            // extract the time zones.
            self::extractTimeZones($xml);
        }
        
        private static function extractMessageTypes($xml){
            $messageTypesNode = $xml->settings->general->messageTypes;
            
            foreach ($messageTypesNode->type as $typeInfo){
                $messageType['id'] = (int)$typeInfo->id;
                $messageType['label'] = (string)$typeInfo->label;
                $messageType['singleLen'] = (int)$typeInfo->singleLen;
                $messageType['concatLen'] = (int)$typeInfo->concatLen;
                $messageType['charLen'] = (int)$typeInfo->charLen;
                
                self::$messageTypes[] = $messageType;
            }
        }
        
        private static function extractTimeZones($xml){
            $timezonesNode = $xml->settings->general->timeZones->region;
            
            foreach ($timezonesNode as $region){
                $regionName = (string)$region['name'];
                $cities = array();
                
                // each region has a list of cities and their respective timezones
                foreach ($region->city as $cityInfo){
                    $city = (string)$cityInfo;
                    $tzOffset = (string)$cityInfo['offset'];
                    
                    $cities[] = array($city, $tzOffset);
                }
                
                self::$timeZones[$regionName] = $cities;
            }
        }
        
        public static function isValidMessageCategory($category){
            switch ($category){
                case MessageCategory::MC_SMS:
                case MessageCategory::MC_VOICE:
                    return true;
                    
                default:
                    return false;
            }
        }
        
        public static function messageTypeToEnum($type){
            if (is_null($type) || !is_string($type) || empty($type))
                throw new \Exception('Invalid text message type label.');
            
            if (is_null(self::$messageTypes))
                throw new \Exception('Text message types have not been loaded.');
            
            foreach (self::$messageTypes as $typeInfo){
                if (strtolower($typeInfo['label']) == strtolower($type)){
                    // return the identifier
                    return $typeInfo['id'];
                }
            }
            
            throw new \Exception("Text message type '{$type}' was not found.");
        }
        
        public static function messageTypeToStr($type){
            if (is_null($type) || !TextMessageType::isDefined($type))
                throw new \Exception('Invalid text message type identifier.');
            
            foreach (self::$messageTypes as $typeInfo){
                if ($type == $typeInfo['id'])
                    return $typeInfo['label'];
            }
            
            throw new \Exception("Text message type identifier '{$type}' was not found.");
        }
        
        public static function getMessageTypeInfo($type){
            if (is_null(self::$messageTypes))
                throw new \Exception('Text message types have not been loaded.');
            
            // we expect it to be a defined message type, not a string
            if (is_null($type) || !TextMessageType::isDefined($type))
                throw new \Exception('Invalid text message type identifier.');
            
            foreach (self::$messageTypes as $typeInfo){
                if ($typeInfo['id'] == $type)
                    return $typeInfo;
            }
        }
        
        public static function dateTimeToStr($dateTime){
            if (is_null($dateTime) || $dateTime instanceof \DateTime == false)
                throw new \Exception('Invalid data time object for conversion.');
            
            return $dateTime->format(self::DATETIME_FORMAT);
        }
        
        public static function getMessageCategoryLabel($category){
            switch ($category){
                case MessageCategory::MC_SMS:
                    return "sms";
                    
                case MessageCategory::MC_VOICE:
                    return "voice";
                    
                case MessageCategory::MC_USSD:
                    return "ussd";
                    
                default:
                    throw new \Exception('Unknown composer category identifier.');
            }
        }
        
        public static function isNumericSender($senderId){
            return preg_match('/^(\+)?\d+$/', $senderId);
        }
        
        public static function getTimeZones(){
            return self::$timeZones;
        }
        
        public static function getTextMessageTypes(){
            return self::$messageTypes;
        }
    }