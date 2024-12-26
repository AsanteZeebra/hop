<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    namespace Zenoph\Notify\Build\Writer;
    
    use Zenoph\Notify\Build\Writer\KeyValueDataWriter;
    
    class MultiPartDataWriter extends KeyValueDataWriter {
        const PSND_VALUES_UNIT_SEP = "__@_";
        const PSND_VALUES_GRP_SEP = "__#_";
        
        public function __construct() {
            parent::__construct();
        }
        
        public function &writeVoiceRequest($vmcArr) {
            
        }
    }