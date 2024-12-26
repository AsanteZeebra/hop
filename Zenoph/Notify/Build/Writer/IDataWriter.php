<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    namespace Zenoph\Notify\Build\Writer;
    
    interface IDataWriter {
        function &writeScheduledMessageDestinationsLoadRequest($templateId);
        function &writeScheduledMessageUpdateRequest($mc);
        function &writeScheduledMessagesLoadRequest($filter);
        function &writeDestinationsData($mc);
        function &writeSMSRequest($tmcArr);
        function &writeVoiceRequest($vmcArr);
        function &writeUSSDRequest($ucArr);
        function &writeDestinationsDeliveryRequest($templateId, $messageIdsArr);
        function &writeMessageDeliveryRequest($templateId);
        function &writeDispatchScheduledMessageRequest($templateId);
        function &writeCancelScheduleRequest($templateId);
    //    function &writeCreditBalanceRequest();
    //    function &writeAuthRequest();
    }