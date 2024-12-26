<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class NumberAddInfo {
        const NAI_OK = 0;
        const NAI_REJTD_INVALID = 1;
        const NAI_REJTD_EXISTS = 2;
        const NAI_REJTD_ROUTE = 3;
        const NAI_REJTD_MSGID_LENGTH = 4;
        const NAI_REJTD_MSGID_EXISTS = 5;
        const NAI_REJTD_MSGID_INVALID = 6;
        const NAI_REJTD_VALUES_EMPTY = 7;
        const NAI_REJTD_VALUES_EXIST = 8;
        const NAI_REJTD_VALUES_COUNT = 9;
        const NAI_REJTD_VALUES_MISVAL = 10;
        const NAI_REJTD_NON_PSND = 11;
    }