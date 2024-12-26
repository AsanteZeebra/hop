<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Enums\AuthModel;
    use Zenoph\Notify\Store\AuthProfile;
    use Zenoph\Notify\Utils\MessageUtil;
    use Zenoph\Notify\Response\AuthResponse;
    
    class AuthRequest extends NotifyRequest {
        public function __construct() {
            parent::__construct();
            $this->_loadaps = true;
        }
        
        private function initAuthProfile(){
            $authProfile = null;
            
            if ($this->_loadaps){
                // Authentication profile
                $authProfile = new AuthProfile();
                $authProfile->setAuthModel($this->_authModel);

                if ($this->_authModel == AuthModel::PORTAL_PASS){
                    $authProfile->setAuthLogin($this->_authLogin);
                    $authProfile->setAuthPassword($this->_authPsswd);
                }
                else if ($this->_authModel == AuthModel::API_KEY) {
                    $authProfile->setAuthApiKey($this->_authApiKey);
                }
            }
            
            return $authProfile;
        }
        
        public function submit() {
            $this->setRequestResource('auth');
            $this->initRequest();
        //    $dataWriter = $this->createDataWriter();
        //    $this->_requestData = &$dataWriter->writeAuthRequest();
            
            $apiResponse = parent::submit();
            $authProfile = $this->initAuthProfile();
            
            // data as array
            $data = array('response'=>$apiResponse, 'authProfile'=>$authProfile);
            
            // create and return auth response
            return AuthResponse::create($data);
        }
  
        public function authenticate(){
            // call submit for AuthResponse
            return $this->submit()->getAuthProfile();
        }
    }
