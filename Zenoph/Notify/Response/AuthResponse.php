<?php

    namespace Zenoph\Notify\Response;
    
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Store\AuthProfile;
    
    class AuthResponse extends APIResponse {
        private $_authProfile = null;
        
        private function __construct() {
            parent::__construct();
        }
        
        private static function validateData(&$data){
            if (is_null($data) || !is_array($data))
                throw new \Exception('Invalid reference to authentication data.');
            
            // check to ensure keys exist
            if (!array_key_exists('response', $data) || $data['response'] instanceof APIResponse === false)
                throw new \Exception('Invalid authentication response.');
            
            if (!array_key_exists('authProfile', $data) || $data['authProfile'] instanceof AuthProfile === false)
                throw new \Exception('Invalid authentication profile.');
        }
        
        public static function create(&$data){
            // perform validation
            self::validateData($data);
            
            $authResponse = new AuthResponse();
            $authResponse->_authProfile = $data['authProfile'];
            $authResponse->_httpStatusCode = $data['response']->getHttpStatusCode();
            $authResponse->_requestHandShake = $data['response']->getRequestHandShake();
            
            if (!is_null($authResponse->_authProfile)){
                $response = $data['response'];
                
                // extract data
                $dataFragment = &$response->getDataFragment();
                $authResponse->_authProfile->extractUserData($dataFragment);
                MessageUtil::extractGeneralSettings($dataFragment);
            }
            
            return $authResponse;
        }
        
        public function getAuthProfile(){
            return $this->_authProfile;
        }
    }
    