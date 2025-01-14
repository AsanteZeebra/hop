<?php

require('Zenoph\Notify\AutoLoader.php');
use Zenoph\Notify\Enums\AuthModel;
use Zenoph\Notify\Enums\TextMessageType;
use Zenoph\Notify\Request\SMSRequest;

include_once('database_connection.php');

// Fetch members whose birthday is today
try {
    $today = date('m-d'); // Extract today's month and day
    $sql = "SELECT fullname, telephone FROM members WHERE DATE_FORMAT(dob, '%m-%d') = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fullname = $row['fullname'];
            $telephone = $row['telephone'];

            // Compose the birthday wish message
            $message = "Heavenoo, Happy Birthday $fullname! Wishing you a wonderful day filled with joy and success. - HOP TEMA";

            // Insert the message into the sms_queue table
            $insert_sql = "INSERT INTO sms_queue (fullname, telephone, message, status) VALUES (?, ?, ?, 'pending')";
            $insert_stmt = $con->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $fullname, $telephone, $message);
            $insert_stmt->execute();
        }
        echo "Birthday messages added to the queue.<br>";
    } else {
        echo "No birthdays today.<br>";
    }
} catch (\Exception $ex) {
    die("Error: Could not fetch birthdays - " . $ex->getMessage());
}

// Process the SMS queue
try {
    $sql = "SELECT id, telephone, message FROM sms_queue WHERE status = 'pending' LIMIT 10";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        SMSRequest::setHost("api.smsonlinegh.com");
        SMSRequest::useSecureConnection(false);

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $telephone = $row['telephone'];
            $message = $row['message'];

            try {
                // Create a new SMSRequest instance
                $sr = new SMSRequest();
                $sr->setAuthModel(AuthModel::API_KEY);
                $sr->setAuthApiKey("df83352ff6a407fb5a62abd9754f1952d50ad7124fa2d6e42c6660768e22f139");
                $sr->setMessage($message);
                $sr->setMessageType(TextMessageType::TEXT);
                $sr->setSender("Zeebra Tech"); // Registered sender ID
                $sr->addDestination($telephone);

                // Send SMS
                $sr->submit();

                // Update queue status to 'sent'
                $update_sql = "UPDATE sms_queue SET status = 'sent' WHERE id = ?";
                $stmt = $con->prepare($update_sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();

                echo "Message sent to $telephone successfully.<br>";
            } catch (\Exception $ex) {
                // Update queue status to 'failed' if SMS sending fails
                $update_sql = "UPDATE sms_queue SET status = 'failed' WHERE id = ?";
                $stmt = $con->prepare($update_sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();

                echo "Failed to send message to $telephone: " . $ex->getMessage() . "<br>";
            }
        }
    } else {
        echo "No messages in queue.<br>";
    }
} catch (\Exception $ex) {
    die("Error: Could not process SMS queue - " . $ex->getMessage());
}

mysqli_close($con);
?>
