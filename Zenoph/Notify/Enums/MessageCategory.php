<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class MessageCategory {
        const MC_SMS = 1;
        const MC_VOICE = 2;
        const MC_USSD = 3;
        
        public static function isDefined($category){
            $reflector = new \ReflectionClass(__CLASS__);
            $constants = $reflector->getConstants();
            
            foreach ($constants as $constVal){
                if ($category == $constVal)
                    return true;
            }
            
            return false;
        }
    }