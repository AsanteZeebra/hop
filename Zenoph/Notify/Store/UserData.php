<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Store;
    
    use Zenoph\Notify\Utils\PhoneUtil;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Enums\MessageCategory;
    
    final class UserData {
        private $textMessageTypeId = null;
        private $routeFilters = null;
        private $messageSenders = null;
        private $defaultRoute = null;
        private $defDialCode = null;
        private $timeZone = null;
        
        public function formatPhoneNumber($phoneNumber, $throwEx = false) {
            if (is_null($phoneNumber) || empty($phoneNumber)) {
                if (!$throwEx)
                    return null;
                
                throw new \Exception("Invalid phone number for formatting.");
            }
            
            // remove number prefixes such as '+', '00', or '0'
            $fmtdNumber = PhoneUtil::stripPhoneNumberPrefixes($phoneNumber);
            
            // if the phone number is not in international format, it will have to be
            // converted to international number format.
            if ($this->isNationalPhoneNumber($fmtdNumber, $this->defaultRoute)){
                // we will need the default dial code for converting into international format.
                // Since this can be changed, don't rely on the default loaded from server.
                // If we do not have a separate copy saved, we will have to save the server default.
                if (is_null($this->defDialCode) || empty($this->defDialCode))
                    $this->setDefaultDialCodeCopy ($this->defaultRoute);
                
                // now convert to international number format.
                $fmtdNumber = "{$this->defDialCode}{$fmtdNumber}";
            }
            
            $matchedPrefix = null;
            
            foreach ($this->routeFilters as $key=>$filter){
                $match = array();
                $dialCode = $filter['dialCode'];
                
                if (!is_null($filter['networksFilter'])) {
                    $filterStr = "(?:{$dialCode}{$filter['networksFilter']})";
                
                    preg_match_all("/^{$filterStr}$/", $fmtdNumber, $match, PREG_SET_ORDER);
                
                    if (count($match) > 0)
                        return self::createDestinationCountryMap ($match[0][0], $key);
                }
                
                // no networks filter matched
                if ($filter['usesAreaCodes']) {
                    $filterStr = "(?:{$dialCode}{$filter['areaCodesFilter']})";
                    preg_match_all("/^{$filterStr}$/", $fmtdNumber, $match, PREG_SET_ORDER);
                    
                    if (count($match) > 0)
                        return self::createDestinationCountryMap ($match[0][0], $key);
                }
                
                // if still not matched, use the relaxed country prefix filter
                $prefixFilter = "^{$dialCode}[0-9]{{$filter['cnum_minlen']},{$filter['cnum_maxlen']}}$";
                preg_match_all("/{$prefixFilter}/", $fmtdNumber, $match, PREG_SET_ORDER);
                
                if (count($match) > 0) {
                    return self::createDestinationCountryMap($fmtdNumber, $matchedPrefix);
                }
            }

            if (!$throwEx)
                return null;
            
            throw new \Exception("Phone number '{$phoneNumber}' is not permitted on routes.");
        }
        
        private function isNationalPhoneNumber($phonenum, &$defRoute){
            $len = strlen($phonenum);
            $minLen = (int)$defRoute['minNumLen'];
            $maxLen = (int)$defRoute['maxNumLen'];
            
            // national number format must be equal or within the minimum and maximum lengths.
            return ($len >= $minLen && $len <= $maxLen);
        }
        
        private function setDefaultDialCodeCopy(&$defRoute){
            // save a copy of the default dial code retrieved from the server.
            $this->defDialCode = $defRoute['dialCode'];
        }
        
        private function hasCountryDialCode($dialCode){
            foreach ($this->routeFilters as $key=>$filter){
                if ($filter['dialCode'] == $dialCode)
                    return true;
            }
            
            return false;
        }
        
        public function setDefaultDialCode($dialCode) {
            // dial code must be set to some value.
            if (is_null($dialCode) || empty($dialCode))
                throw new \Exception('Invalid value for setting default dial code.');
            
            // clean the input
            $c_dialCode = preg_replace("/(\+)|(00)/", "", $dialCode);
            
            // it should contain something after cleaning. Also ensure it is numeric
            if (is_null($c_dialCode) || empty($c_dialCode) || !is_numeric($c_dialCode))
                throw new \Exception("Invalid value '{$dialCode}' for setting default dial code.");
                
            if (!$this->hasCountryDialCode($dialCode))
                throw new \Exception("Country dial code '{$dialCode}' is not applicable to user routes.");
            
            // set it.
            $this->defDialCode = $c_dialCode;
        }
        
        public function setDefaultNumberPrefix($prefix){
            $this->setDefaultDialCode($prefix);
        }
        
        public function getDefaultDialCode() {
            // it is possible for the copy to be unset.
            if (is_null($this->defDialCode) || empty($this->defDialCode)){
                if (!is_null($this->userData)){
                    $this->setDefaultDialCodeCopy($this->defaultRoute);
                }
            }
            
            // now return the default dial code.
            return $this->defDialCode;
        }
        
        public function getDefaultNumberPrefix(){
            return $this->getDefaultDialCode();
        }
        
        public function getRouteCountries(){
            if (is_null($this->routeFilters))
                throw new \Exception('Route countries have not been loaded.');
            
            $countriesList = array();
            
            foreach ($this->routeFilters as $key=>$filter){
                $countryCode = $key;
                $countryName = $filter['countryName'];
                $dialCode = $filter['dialCode'];
                
                $countriesList[] = array($countryName, $countryCode, $dialCode);
            }
            
            return $countriesList;
        }
        
        public static function createDestinationCountryMap($phoneNumber, $countryCode){
            return array($phoneNumber, $countryCode);
        }
        
        public static function create(&$df){
            $xml = simplexml_load_string($df);
            $userSettingsNode = $xml->settings->user;
            
            $userData = new UserData();
            $userData->timeZone = (string)$userSettingsNode->timeZone;
            $userData->textMessageTypeId = (int)$userSettingsNode->messageType;
            
            // default route info
            $userData->defaultRoute['countryName'] = (string)$userSettingsNode->defDestination->countryName;
            $userData->defaultRoute['countryCode'] = (string)$userSettingsNode->defDestination->countryCode;
            $userData->defaultRoute['dialCode'] = (int)$userSettingsNode->defDestination->dialCode;
            $userData->defaultRoute['minNumLen'] = (int)$userSettingsNode->defDestination->minNumLen;
            $userData->defaultRoute['maxNumLen'] = (int)$userSettingsNode->defDestination->maxNumLen;
            
            // route filters
            $userData->routeFilters = &self::extractRouteFilters($userSettingsNode);
            
            // message senders, if any
            if (isset($userSettingsNode->messageSenders)){
                self::extractMessageSenders($userSettingsNode, $userData);
            }
            
            return $userData;
        }
        
        private static function &extractRouteFilters($node){
            $filters = null;
            
            foreach ($node->routeFilters->filter as $filter){
                // Get the country code. It will be used as key
                $countryCode = strtolower((string)$filter->countryCode);
                
                // the filter pattern can be null for user country without a network identifier added
                $networksFilter = (string)$filter->networksFilter;
                $areaCodesFilter = (string)$filter->areaCodesFilter;
                
                if (is_null($networksFilter) || empty($networksFilter) || strtolower($networksFilter) == 'null')
                    $networksFilter = null;
                if (is_null($areaCodesFilter) || empty($areaCodesFilter) || strtolower($areaCodesFilter) == 'null')
                    $areaCodesFilter = null;
                
                $filters[$countryCode]['networksFilter'] = $networksFilter;
                $filters[$countryCode]['areaCodesFilter'] = $areaCodesFilter;
                $filters[$countryCode]['usesAreaCodes'] = ((string)$filter->usesAreaCodes) == 'true';
                $filters[$countryCode]['countryName'] = (string)$filter->countryName;
                $filters[$countryCode]['dialCode'] = (int)$filter->dialCode;
                $filters[$countryCode]['cnum_minlen'] = (int)$filter->cnum_minlen;
                $filters[$countryCode]['cnum_maxlen'] = (int)$filter->cnum_maxlen;
                $filters[$countryCode]['registerSender'] = strtolower((string)$filter->registerSender) === 'true';
                $filters[$countryCode]['numericSenderAllowed'] = strtolower((string)$filter->numericSenderAllowed) === 'true';
            }
            
            return $filters;
        }

        private static function extractMessageSenders($baseNode, &$userData){
            $smsLabel = MessageUtil::getMessageCategoryLabel(MessageCategory::MC_SMS);
            $voiceLabel = MessageUtil::getMessageCategoryLabel(MessageCategory::MC_VOICE);
            
            // SMS message senders
            if (isset($baseNode->messageSenders->{$smsLabel})){
                $userData->messageSenders[$smsLabel] = &self::pullSenders($baseNode, $smsLabel);
            }
            
            // voice message senders, (If they are explicitly assigned)
            if (isset($baseNode->messageSenders->{$voiceLabel})){
                $userData->messageSenders[$voiceLabel] = &self::pullSenders($baseNode, $voiceLabel);
            }
            
            // countries info for lookup
            $userData->messageSenders['countries'] = &self::pullSenderCountries($baseNode);
        }
        
        private static function &pullSenderCountries($baseNode){
            $countriesData = null;
            
            if (!isset($baseNode->messageSenders->countries->country))
                return $countriesData;
            
            $countriesContainer = $baseNode->messageSenders->countries;
            
            foreach ($countriesContainer->country as $countryInfo){
                $name = (string)$countryInfo->name;
                $code = (string)$countryInfo->code;
                
                // add to countries
                $countriesData[$code] = $name;
            }
            
            // return the countries which will be used for lookup
            return $countriesData;
        }
        
        private static function &pullSenders($baseNode, $categoryLabel){
            $sendersNode = $baseNode->messageSenders->{$categoryLabel};
            $messageSenders = null;
            
            foreach ($sendersNode->sender as $sdrData){
                $senderName = (string)$sdrData->name;
                $caseSensitive = strtolower((string)$sdrData->caseSensitive) === 'true';

                // we expect country codes
                if (!isset($sdrData->countryCodes->code))
                    continue;
                
                $countryCodesContainer = $sdrData->countryCodes;
                $senderCtryCodes = array();
                
                foreach ($countryCodesContainer->code as $countryCode){
                    $senderCtryCodes[] = (string)$countryCode;
                }
                
                // sender info
                $senderInfo['sensitive'] = $caseSensitive;
                $senderInfo['countryCodes'] = $senderCtryCodes;
                
                // add to senders list
                $messageSenders[$senderName] = $senderInfo;
            }
            
            return $messageSenders;
        }
        
        public function getDefaultTextMessageType(){
            return $this->textMessageTypeId;
        }
        
        public function getRouteFilters(){
            return $this->routeFilters;
        }
        
        public function getMessageSenders(){
            return $this->messageSenders;
        }
        
        public function getDefaultTimeZone(){
            if (!is_null($this->timeZone))
                return explode("/", $this->timeZone);
            
            # not set
            return null;
        }
        
        public function getDefaultRouteInfo(){
            return $this->defaultRoute;
        }
    }