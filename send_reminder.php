<?php
include_once('database_connection.php');

// Fetch members who haven't received the reminder
$sql = "SELECT fullname, telephone FROM members WHERE reminder_sent = 0";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fullname = $row['fullname'];
        $telephone = $row['telephone'];
        $message = "Dear $fullname, this is a reminder to pay your monthly dues. Thank you.";

        // Insert into sms_queue
        $insert_sql = "INSERT INTO sms_queue (fullname, telephone, message, status) VALUES (?, ?, ?, 'pending')";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("sss", $fullname, $telephone, $message);
        $stmt->execute();
    }
    echo "Messages added to queue.";
} else {
    echo "No members found.";
}



require('Zenoph\Notify\AutoLoader.php');
use Zenoph\Notify\Enums\AuthModel;
use Zenoph\Notify\Enums\TextMessageType;
use Zenoph\Notify\Request\SMSRequest;



try {
    // Fetch pending messages from the queue in batches
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
                $sr->setSender("Zeebra Tech");
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
                // Update queue status to 'failed' if SMS fails
                $update_sql = "UPDATE sms_queue SET status = 'failed' WHERE id = ?";
                $stmt = $con->prepare($update_sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                echo "Failed to send message to $telephone: " . $ex->getMessage() . "<br>";
            }
        }
    } else {
        echo "No messages in queue.";
    }
} catch (\Exception $ex) {
    die("Error: " . $ex->getMessage());
}

mysqli_close($con);





?>
