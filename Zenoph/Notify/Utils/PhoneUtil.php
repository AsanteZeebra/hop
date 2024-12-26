<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Utils;
    
    final class PhoneUtil {
        const PHONENUM_PATTERN = '\+?[0-9]{8,13}';  // taking notice of length of phone number
        
        public function __construct() {
            
        }

        public static function isValidPhoneNumber($phoneNumber){
            return preg_match("/^".self::PHONENUM_PATTERN."$/", $phoneNumber);
        }
        
        public static function stripPhoneNumberPrefixes($phoneNumber){
            // remove any non-digits, especially to get rid of the '+' sign, if there is
            $phoneNumber = preg_replace("/[^\d]/", "", $phoneNumber);

            // now check for zeros indicating national or international number format.
            if (substr($phoneNumber, 0, 2) == "00")
                $phoneNumber = substr ($phoneNumber, 2);
            else if (substr($phoneNumber, 0, 1) == "0")
                $phoneNumber = substr ($phoneNumber, 1);
            
            // return result.
            return $phoneNumber;
        }
        
        public static function &extractPhoneNumbers($str) {
            if (is_null($str) || empty($str))
                throw new \Exception('Invalid reference to text stream for extracting phone numbers.');
            
            $validList = null;
            $matches = array();
            preg_match_all("/".self::PHONENUM_PATTERN."/", $str, $matches, PREG_SET_ORDER);
            
            // if no matches, return empty array.
            if (is_null($matches) || count($matches) == 0)
                return null;
            
            for ($i = 0; $i < count($matches); ++$i){
                $validList[] = $matches[$i][0];
            }
            
            return $validList;
        }
    }