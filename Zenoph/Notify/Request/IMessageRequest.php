<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    namespace Zenoph\Notify\Request;
    
    interface IMessageRequest {
        static function &submitMessageContainer(&$message, $param1, $param2 = null);
    }