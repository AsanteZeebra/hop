<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class DataContentType {
        const DCT_XML = 0;
        const DCT_JSON = 1;
        const DCT_WWW_URL_ENCODED = 2;
        const DCT_MULTIPART_FORM_DATA = 3;
        const DCT_GZBIN_XML = 4;
        const DCT_GZBIN_JSON = 5;
        const DCT_GZBIN_WWW_URL_ENCODED = 6;
    }