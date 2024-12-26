<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class MessageValidation {
        const MV_NONE = 1301;
        const MV_OK = 1302;
        const MV_ERR_INTERNAL = 1303;
        const MV_ERR_DATA = 1304;
        const MV_ERR_MESSAGE = 1305;
        const MV_ERR_MESSAGE_TYPE = 1306;
        const MV_ERR_SENDER = 1307;
        const MV_ERR_SENDER_NUMERIC = 1308;
        const MV_ERR_SENDER_PROHIBITED = 1309;
        const MV_ERR_PSND_VALUES = 1310;
        const MV_ERR_DESTINATION = 1311;
        const MV_ERR_SCHEDULE_DATETIME = 1312;
        const MV_ERR_SCHEDULE_OFFSET = 1313;
        const MV_ERR_SCHEDULE_DUE = 1314;
        const MV_ERR_WAP_PUSH_URL = 1315;
        const MV_ERR_NOTIFY_URL = 1316;
        const MV_ERR_NOTIFY_ACCEPT = 1317;
        const MV_ERR_AUDIO = 1318;
        const MV_ERR_INVALID_VOICE_HANDLE = 1319;
        const MV_ERR_TPL_REF_EXISTS  = 1320;
        const MV_ERR_TPL_REF_INVALID = 1321;
        const MV_ERR_TPL_SAVE_ERROR  = 1322;
    }