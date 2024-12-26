<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    abstract class DestinationStatus {
        const DS_UNKNOWN = 2101;
        const DS_SCHEDULE_CANCELLED = 2102;
        const DS_SCHEDULE_DELETED = 2103;
        const DS_SUBMIT_SCHEDULED = 2104;
        const DS_SUBMIT_ENROUTE = 2105;
        const DS_SUBMIT_PROCESSING = 2106;
        const DS_SUBMIT_QUEUED = 2107;
        const DS_PENDING_DELIV_REPT = 2108;
        const DS_SUBMITTED = 2109;
        const DS_DELIVERED = 2110;
        const DS_EXPIRED = 2111;
        const DS_UNDELIVERED = 2112;
        const DS_REJECTED = 2113;
        const DS_REJECTED_SYSTEM = 2114;
        const DS_REJECTED_VALUES_EMPTY = 2115;
        const DS_REJECTED_VALUES_MISVAL = 2116;
        const DS_REJECTED_VALUES_EXISTS = 2117;
        const DS_REJECTED_VALUES_COUNT = 2118;
        const DS_REJECTED_DESTINATION = 2119;
        const DS_REJECTED_DESTINATION_DUPLICATE = 2120;
        const DS_REJECTED_INSUFF_CREDIT = 2121;
        const DS_REJECTED_NETWORK = 2122;
        const DS_REJECTED_NETWORK_IGNORED = 2123;
        const DS_REJECTED_MESSAGE = 2124;
        const DS_REJECTED_MESSAGE_TYPE = 2125;
        const DS_REJECTED_SENDER = 2126;
        const DS_REJECTED_SENDER_NUMERIC = 2127;
        const DS_REJECTED_SENDER_UNREGISTERED = 2128;
        const DS_REJECTED_OPERATOR = 2129;
        const DS_REJECTED_OPERATOR_SPAM = 2130;
        const DS_REJECTED_MSGID_DUPLICATE = 2131;
        const DS_REJECTED_MSGID_LENGTH = 2132;
        const DS_REJECTED_MSGID_INVALID = 2133;
        const DS_REJECTED_UNAV_CONN = 2134;
        const DS_REJECTED_SCHEDULE = 2135;
        const DS_REJECTED_WAP_TITLE = 2136;
        const DS_REJECTED_WAP_URL = 2137;
        const DS_IGNORED_LOAD_MAX = 2138;
        const DS_SUBMIT_PENDING_ACK = 2139;
        
        public static function isDefined($statusId){
            $reflector = new \ReflectionClass(__CLASS__);
            $constants = $reflector->getConstants();
            
            foreach ($constants as $constVal){
                if ($statusId === $constVal)
                    return true;
            }
            
            return false;
        }
    }