<?php

    namespace Zenoph\Notify\Compose;
    
    interface IVoiceComposer {
        function setOfflineVoice($fileName, $saveRef = null);
        function getOfflineVoice();
        function setTemplateReference($ref);
        function getTemplateReference();
        function isOfflineVoice();
    }