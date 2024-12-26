<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Utils;
    
    use Zenoph\Notify\Enums\DataContentType;
    
    class RequestUtil {
        private static $__DCTL_APPLICATION_XML__;
        private static $__DCTL_APPLICATION_JSON__;
        private static $__DCTL_APPLICATION_URL_ENCODED__;
        private static $__DCTL_MULTIPART_FORM_DATA__;
        private static $__DCTL_APPLICATION_GZBIN_XML__;
        private static $__DCTL_APPLICATION_GZBIN_JSON__;
        private static $__DCTL_APPLICATION_GZBIN_URL_ENCODED__;
        
        public static function initShared(){
            self::$__DCTL_APPLICATION_XML__ = 'application/xml';
            self::$__DCTL_APPLICATION_JSON__ = 'application/json';
            self::$__DCTL_APPLICATION_URL_ENCODED__ = 'application/x-www-form-urlencoded';
            self::$__DCTL_MULTIPART_FORM_DATA__ = 'multipart/form-data';
            self::$__DCTL_APPLICATION_GZBIN_XML__ = 'application/vnd.zenoph.zbm.gzbin+xml';
            self::$__DCTL_APPLICATION_GZBIN_JSON__ = 'application/vnd.zenoph.zbm.gzbin+json';
            self::$__DCTL_APPLICATION_GZBIN_URL_ENCODED__ = 'application/vnd.zenoph.zbm.gzbin+urlencoded';
        }
        
        public static function isValidContentTypeLabel($label){
            if (is_null($label) || empty($label))
                throw new \Exception('Invalid content type label for verification.');
            
            switch ($label){
                case self::$__DCTL_APPLICATION_XML__:
                case self::$__DCTL_APPLICATION_GZBIN_XML__:
                case self::$__DCTL_APPLICATION_JSON__:
                case self::$__DCTL_APPLICATION_GZBIN_JSON__:
                case self::$__DCTL_APPLICATION_URL_ENCODED__:
                case self::$__DCTL_APPLICATION_GZBIN_URL_ENCODED__:
                case self::$__DCTL_MULTIPART_FORM_DATA__:
                    return true;
                    
                default:
                    return false;
            }
        }
        
        public static function getDataContentTypeLabel($type){
            switch ($type){
                case DataContentType::DCT_XML:
                    return self::$__DCTL_APPLICATION_XML__;
                    
                case DataContentType::DCT_JSON:
                    return self::$__DCTL_APPLICATION_JSON__;
                    
                case DataContentType::DCT_WWW_URL_ENCODED:
                    return self::$__DCTL_APPLICATION_URL_ENCODED__;
                    
                case DataContentType::DCT_MULTIPART_FORM_DATA:
                    return self::$__DCTL_MULTIPART_FORM_DATA__;
                    
                case DataContentType::DCT_GZBIN_XML:
                    return self::$__DCTL_APPLICATION_GZBIN_XML__;
                
                case DataContentType::DCT_GZBIN_JSON:
                    return self::$__DCTL_APPLICATION_GZBIN_JSON__;
                    
                case DataContentType::DCT_GZBIN_WWW_URL_ENCODED:
                    return self::$__DCTL_APPLICATION_GZBIN_URL_ENCODED__;
                    
                default:
                    throw new \Exception('Unknown data content type identifier for label.');
            }
        }
        
        public static function getDataContentTypeFromLabel($label){
            switch ($label){
                case self::$__DCTL_APPLICATION_XML__:
                    return DataContentType::DCT_XML;
                    
                case self::$__DCTL_APPLICATION_JSON__:
                    return DataContentType::DCT_JSON;
                    
                case self::$__DCTL_APPLICATION_URL_ENCODED__:
                    return DataContentType::DCT_WWW_URL_ENCODED;
                    
                case self::$__DCTL_MULTIPART_FORM_DATA__:
                    return DataContentType::DCT_MULTIPART_FORM_DATA;
                    
                case self::$__DCTL_APPLICATION_GZBIN_XML__:
                    return DataContentType::DCT_GZBIN_XML;
                    
                case self::$__DCTL_APPLICATION_GZBIN_JSON__:
                    return DataContentType::DCT_GZBIN_JSON;
                    
                case self::$__DCTL_APPLICATION_GZBIN_URL_ENCODED__:
                    return DataContentType::DCT_GZBIN_WWW_URL_ENCODED;
                    
                default:
                    throw new \Exception('Unknown label for data content type identifier.');
            }
        }
        
        public static function &compressData(&$dataStr){
            if (is_null($dataStr) || empty($dataStr))
                throw new \Exception('Invalid data stream for compression.');
            
            $gzData = base64_encode(gzencode($dataStr, 6));

            // return compressed data
            return $gzData;
        }
        
        public static function &decompressData(&$dataStr){
            if (is_null($dataStr) || empty($dataStr))
                throw new \Exception('Invalid data stream for decompression.');

            // first, decode from base64
            $decoded = gzdecode(base64_decode($dataStr));
            
            // return decoded data
            return $decoded;
        }
    }
    
    RequestUtil::initShared();