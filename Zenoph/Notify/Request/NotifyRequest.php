<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Request;
    
    use Zenoph\Notify\Enums\HTTPCode;
    use Zenoph\Notify\Enums\AuthModel;
    use Zenoph\Notify\Enums\DataContentType;
    use Zenoph\Notify\Utils\RequestUtil;
    use Zenoph\Notify\Response\APIResponse;
    use Zenoph\Notify\Store\AuthProfile;
    use Zenoph\Notify\Build\Writer\DataWriter;
    
    abstract class NotifyRequest {
        protected $_authModel = null;
        protected $_authLogin = null;
        protected $_authPsswd = null;
        protected $_authApiKey = null;
        protected $_requestData = null;
        protected $_authProfile = null;
        protected $_loadaps = false;
        private $_requestURL = null;
        
        private static $caInfoFileName = null;
        private static $_AUTH_FACTOR_SEPARATOR;
        private static $_useLocalCert = false;
        private static $_gSecureConn;
        private static $_gHttpPort;
        private static $_gHttpsPort;
        private static $_gHost = null;
        
        protected $_contentType  = null;
        protected $_acceptType = null;
        protected $_urlScheme = "http";
        
        protected $_requestResource = null;
        
        const __API_TARGET_VERSION__ = 4;
        
        public function __construct($ap = null) {
            if (!is_null($ap)){
                $this->validateAuthProfile($ap);
                $this->_authProfile = $ap;
            }
            
            // authentication model
            $this->_authModel   = AuthModel::API_KEY;
            $this->_contentType = DataContentType::DCT_XML;
            $this->_acceptType  = DataContentType::DCT_XML;
            
            // check dependencies
            self::checkDependencies();
        }
        
        protected function validateAuthProfile($ap){
            if (!$ap instanceof AuthProfile)
                throw new \Exception('Invalid authentication profile object.');

            // it should have been authenticated
            if (!$ap->authenticated())
                throw new \Exception('User profile has not been authenticated.');
        }
        
        public function setAuthProfile($ap){
            // validate auth profile
            $this->validateAuthProfile($ap);
            
            // set auth profile
            $this->_authProfile = $ap;
        }
        
        public static function initShared(){
            self::$caInfoFileName = __DIR__.'/../cacert.pem';
            self::$_AUTH_FACTOR_SEPARATOR = "__::";
            
            // global flag for using https or http connection
            self::$_gSecureConn = true;
            
            // default ports that will be used if not explicitly set
            self::$_gHttpPort = 80;
            self::$_gHttpsPort = 443;
            
            // API version targetted
        //    self::$_targetAPIVersion = "v4";
        }
        
        private static function checkDependencies(){
            // the library uses cURL. Check that it is available.
            if (!function_exists('curl_version'))
                throw new \Exception('cURL extension is not available for requests. Please ensure it is installed and enabled.');
        }
        
        public static function setHost($host){
            if (is_null($host) || empty($host))
                throw new \Exception("Invalid request host URL.");
            
            self::$_gHost = $host;
        }

        public static function setHttpPort($port){
            if (is_null($port) || !is_numeric($port) || $port <= 0)
                throw new \Exception('Invalid http port number.');
            
            self::$_gHttpPort = $port;
        }
        
        public static function setHttpsPort($port){
            if (is_null($port) || !is_numeric($port) || $port <= 0)
                throw new \Exception('Invalid https port number.');
            
            self::$_gHttpsPort = $port;
        }
        
        public static function useSecureConnection($secure, $useLocalCert = false, $port = null){
            if (is_null($secure) || !is_bool($secure))
                throw new \Exception('Invalid value for setting global connection protocol.');
            
            self::$_gSecureConn = $secure;
            self::$_useLocalCert = $useLocalCert === true;
            
            // if a port is provided we will set the port for protocol
            if (!is_null($port) && is_int($port) && $port > 0){
                if ($secure){
                    self::setHttpsPort($port);
                }
                else {
                    self::setHttpPort($port);
                }
            }
        }

        public function setAuthModel($model){
            switch ($model){
                case AuthModel::API_KEY:
                case AuthModel::PORTAL_PASS:
                    break;
                
                default:
                    throw new \Exception('Invalid authentication model.');
            }
            
            // set auth model
            $this->_authModel = $model;
        }
        
        public function setAuthLogin($login){
            if (is_null($login) || empty($login))
                throw new \Exception('Missing or invalid account login.');
            
            if ($this->_authModel != AuthModel::PORTAL_PASS)
                throw new \Exception('Invalid call for setting account login.');
            
            $this->_authLogin = $login;
        }
        
        public function setAuthPassword($psswd){
            if (is_null($psswd) || empty($psswd))
                throw new \Exception('Missing or invalid account password.');
            
            if ($this->_authModel != AuthModel::PORTAL_PASS)
                throw new \Exception('Invalid call for setting account password.');
            
            $this->_authPsswd = $psswd;
        }
        
        public function setAuthApiKey($mKey){
            if (is_null($mKey) || empty($mKey))
                throw new \Exception('Missing or invalid API authentication key.');
            
            // auth model must be API_KEY
            if ($this->_authModel != AuthModel::API_KEY)
                throw new \Exception('Invalid call for setting API authentication key.');
            
            $this->_authApiKey = $mKey;
        }
        
        private function validateAuth(){
            if ($this->_authModel == AuthModel::PORTAL_PASS){
                if (is_null($this->_authLogin) || empty($this->_authLogin) ||
                    is_null($this->_authPsswd) || empty($this->_authPsswd))
                    throw new \Exception('Missing account login and or password.');
            }
            else {
                if (is_null($this->_authApiKey) || empty($this->_authApiKey))
                    throw new \Exception('Missing or invalid API key for authentication.');
            }
        }
        
        protected function setRequestResource($resource){
            if (is_null($resource) || empty($resource))
                throw new \Exception('Invalid reference to request resource.');
  
            $this->_requestResource = $resource;
        }
        
        public function setRequestContentType($type){
            if (!$this->requestContentTypeSupported($type))
                throw new \Exception('Unsupported request content type.');
            
            $this->_contentType = $type;
        }
        
        protected function setResponseContentType($type){
            if (!$this->responseContentTypeSupported($type))
                throw new \Exception('Unsupported response content type.');
            
            $this->_acceptType = $type;
        }
        
        public function requestContentTypeSupported($type){
            switch ($type){
                case DataContentType::DCT_XML:
                case DataContentType::DCT_GZBIN_XML:
                case DataContentType::DCT_WWW_URL_ENCODED:
                case DataContentType::DCT_GZBIN_WWW_URL_ENCODED:
                case DataContentType::DCT_MULTIPART_FORM_DATA:
                    return true;
                    
                default:
                    return false;
            }
        }
        
        public function responseContentTypeSupported($type){
            switch ($type){
                case DataContentType::DCT_XML:
                case DataContentType::DCT_GZBIN_XML:
                    return true;
                    
                default:
                    return false;
            }
        }
        
        protected function &prepareRequestData(){
            $postData = null;
            
            switch ($this->_contentType){
                case DataContentType::DCT_XML:
                case DataContentType::DCT_JSON:
                    $postData = &$this->_requestData;
                    break;
                
                case DataContentType::DCT_GZBIN_XML:
                case DataContentType::DCT_GZBIN_JSON:
                    $postData = &RequestUtil::compressData($this->_requestData);
                    break;
                
                case DataContentType::DCT_GZBIN_WWW_URL_ENCODED:
                    $postData = http_build_query($this->_requestData['keyValues']);
                    $postData = &RequestUtil::compressData($postData);
                    break;
                
                case DataContentType::DCT_WWW_URL_ENCODED:
                    $postData = http_build_query($this->_requestData['keyValues']);
                    break;
                
                case DataContentType::DCT_MULTIPART_FORM_DATA:
                    // multipart will be sent as array
                    $postData = array();
                    array_merge($postData, $this->_requestData['keyValues']);
                    
                    // If there is a file and it exists, it should be added
                    if (array_key_exists('file', $this->_requestData)){
                        $fileName = realpath($this->_requestData['file']);
                        
                        if (!file_exists($fileName))
                            throw new \Exception("File '{$fileName}' does not exist for upload.");
                        
                        // create CURLFile and merge for upload
                        $curlFile = new \CURLFile($fileName);
                        array_merge($postData, $curlFile);
                    }
                    
                    break;
            }

            return $postData;
        }
    
        public function submit(){
            // cURL will be used in submitting all request by POST.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_requestURL);

            // Data will be sent by POST method
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareRequestData());
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->prepareHeader());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       
            // If secure connection should be used on local server, 
            // the Certificate Authority Info file must be loaded
            if (self::$_gSecureConn && self::$_useLocalCert) {
                if (!file_exists((self::$caInfoFileName)))
                    throw new \Exception("Certifications authority file was not found.");
                
                // set the CA file to be used
                curl_setopt($ch, CURLOPT_CAINFO, self::$caInfoFileName);
            }
            
            // Execute for response
            $responseBody = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);
            
            // check status code
            $this->assertRequestHTTPCode($httpCode);

            if (is_null($responseBody) || empty($responseBody) || $responseBody == false)
                throw new \Exception('Request submit error.');
  
            // return the web response
            $responseArr = array($httpCode, $contentType, $responseBody);
            return APIResponse::create($responseArr);
        }

        protected function initRequest(){
            if (is_null($this->_requestResource) || empty($this->_requestResource))
                throw new \Exception('Invalid reference to request resource.');
            
            $urlScheme = $this->_urlScheme .(self::$_gSecureConn ? "s" : "");
            $connPort = self::$_gSecureConn ? self::$_gHttpsPort : self::$_gHttpPort;
            $host = self::$_gHost;
            
            // set the request URL
            $this->_requestURL = "{$urlScheme}://{$host}:{$connPort}/v".self::__API_TARGET_VERSION__."/{$this->_requestResource}";
        }
        
        private function extractAuthInfoFromProfile(){
            $this->_authModel = $this->_authProfile->getAuthModel();
            $this->_authLogin = $this->_authProfile->getAuthLogin();
            $this->_authPsswd = $this->_authProfile->getAuthPassword();
            $this->_authApiKey = $this->_authProfile->getAuthApiKey();
        }
        
        protected function createDataWriter(){
            // create data writer and set auth parameters
            return DataWriter::create($this->_contentType);
    /*        $dataWriter->setAuthModel($this->_authModel);
        //    $dataWriter->setAuthPID(self::$_gPID);
            $dataWriter->setAuthAPSLoad($this->_loadaps);
            
            if ($this->_authModel == AuthModel::PORTAL_PASS){
                $dataWriter->setAuthLogin($this->_authLogin);
                $dataWriter->setAuthPassword($this->_authPsswd);
            }
            else {  // api key authentication
                $dataWriter->setAuthApiKey($this->_authApiKey);
            }
*/
            // return data writer
        //    return $dataWriter;
        }
    
        private function assertRequestHTTPCode($code){
            if ($code != HTTPCode::OK){
                switch ($code){
                    case HTTPCode::ERROR_BAD_REQUEST:
                        throw new \Exception('Bad request.');
                        
                    case HTTPCode::ERROR_UNAUTHORIZED:
                        throw new \Exception('Unauthorised request.');
                        
                    case HTTPCode::ERROR_FORBIDDEN:
                        throw new \Exception('Forbidden request.');
                        
                    case HTTPCode::ERROR_NOT_FOUND:
                        throw new \Exception('Request resource not found.');
                        
                    case HTTPCode::ERROR_METHOD_NOT_ALLOWED:
                        throw new \Exception('Request method not allowed.');
                        
                    case HTTPCode::ERROR_NOT_ACCEPTABLE:
                        throw new \Exception('Response content type is not acceptable.');
                        
                    case HTTPCode::ERROR_UNPROCESSABLE:
                        throw new \Exception("Request could not be processed.");
                        
                    case HTTPCode::ERROR_INTERNAL:
                        throw new \Exception('Internal server error.');
                        
                    default:
                        throw new \Exception("Unknown request error <{$code}>.");
                }
            }
        }
        
        private function prepareHeader(){
            $headers = array("Host: ".self::$_gHost,
                    "Accept: ".RequestUtil::getDataContentTypeLabel($this->_acceptType),
                    "Content-Type: ".RequestUtil::getDataContentTypeLabel($this->_contentType),
                    "Authorization: ".$this->getAuthData()
                );
                
            return $headers;
        }
        
        private function generateAuthFactor(){
            if (is_null($this->_authLogin) || empty($this->_authLogin))
                throw new \Exception("Invalid login for generating auth factor.");
            
            if (is_null($this->_authPsswd) || empty($this->_authPsswd))
                throw new \Exception ("Invalid password for generating auth factor.");
            
            return base64_encode("{$this->_authLogin}".self::$_AUTH_FACTOR_SEPARATOR."{$this->_authPsswd}");
        }
        
        private function getAuthData(){
            if (!is_null($this->_authProfile))
                $this->extractAuthInfoFromProfile();
            
            // validate auth
            $this->validateAuth();
            $authStr = "";
            
            switch ($this->_authModel){
                case AuthModel::API_KEY:
                    $authStr = "key {$this->_authApiKey}";
                    break;
                
                case AuthModel::PORTAL_PASS:
                    $authStr = "factor ".$this->generateAuthFactor();
                    break;
                
                default:
                    throw new \Exception('Unsupported request authentication model.');
            }
            
            return "{$authStr}".($this->_loadaps ? "   ls" : "");
        }
        
        protected static function initRequestAuth($request, $param1, $param2 = null){
            if (is_null($request) || !$request instanceof NotifyRequest)
                throw new \Exception('Invalid reference to Request object.');
            
            // authentication details will depend on the parameters supplied. If
            // both parameters are provided, then the authentication model is portal_pass
            // else if the second parameter is not provided then authentication model
            // is API_KEY
            $authModel = AuthModel::API_KEY;
            
            if (!is_null($param2) && !empty($param2))
                $authModel = AuthModel::PORTAL_PASS;

            $request->setAuthModel($authModel);
            
            if ($authModel == AuthModel::API_KEY){
                $request->setAuthApiKey($param1);
            }
            else {
                $request->setAuthLogin($param1);
                $request->setAuthPassword($param2);
            }
        }
    }
    
    NotifyRequest::initShared();