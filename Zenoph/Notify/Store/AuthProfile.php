<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Store;
    
    use Zenoph\Notify\Enums\AuthModel;
    use Zenoph\Notify\Store\UserData;
    
    class AuthProfile {
        private $authLogin = "";
        private $authPassword = "";
        private $authApiKey = "";
        private $authModel = null;
        private $authed = false;
        private $userData = null;
        
        public function __construct() {
            $this->userData = array();
        }
        
        public function authenticated(){
            return $this->authed;
        }
        
        public function getAuthModel(){
            return $this->authModel;
        }
        
        public function setAuthModel($model){
            switch ($model){
                case AuthModel::PORTAL_PASS:
                case AuthModel::API_KEY:
                    break;
                
                default:
                    throw new \Exception('Invalid authentication model specifier.');
            }
            
            // set it.
            $this->authModel = $model;
        }
        
        public function setAuthLogin($login){
            if (is_null($login) || empty($login))
                throw new \Exception('Missing or invalid authentication login.');
            
            $this->authLogin = $login;
        }
        
        public function getAuthLogin(){
            return $this->authLogin;
        }
        
        public function setAuthPassword($psswd){
            if (is_null($psswd) || empty($psswd))
                throw new \Exception('Missing or invalid authentication password.');
            
            $this->authPassword = $psswd;
        }
        
        public function getAuthPassword(){
            return $this->authPassword;
        }
        
        public function setAuthApiKey($apiKey){
            if (is_null($apiKey) || empty($apiKey))
                throw new \Exception('Missing or invalid authentication API key.');
            
            $this->authApiKey = $apiKey;
        }
        
        public function getAuthApiKey(){
            return $this->authApiKey;
        }
        
        public function extractUserData(&$df){
            $this->userData = UserData::create($df);
            $this->authed = true;
        }
        
        public function getUserData(){
            return $this->userData;
        }
    }
