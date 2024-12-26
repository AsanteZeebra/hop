<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class TextMessageType {
        const TEXT = 0;
        const UNICODE = 1;
        const FLASH = 2;
        const FLASH_UNICODE = 3;
        const WAP_PUSH = 4;
        
        public static function isDefined($type){
            $reflector = new \ReflectionClass(__CLASS__);
            $constants = $reflector->getConstants();
            
            foreach ($constants as $constVal){
                if ($type == $constVal)
                    return true;
            }
            
            return false;
        }
    }