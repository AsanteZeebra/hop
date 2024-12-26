<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    namespace Zenoph\Notify\Enums;
    
    class HTTPCode {
        const OK = 200;
        const ERROR_BAD_REQUEST        = 400;
        const ERROR_UNAUTHORIZED       = 401;
        const ERROR_FORBIDDEN          = 403;
        const ERROR_METHOD_NOT_ALLOWED = 405;
        const ERROR_NOT_ACCEPTABLE     = 406;
        const ERROR_UNPROCESSABLE      = 422;
        const ERROR_NOT_FOUND          = 404;
        const ERROR_INTERNAL           = 500;
    }