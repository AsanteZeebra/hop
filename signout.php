<?php
// Initialize the session
session_start();

// Database connection (update with your DB details)
include_once('database_connection.php');


// Get the member ID from the URL
$mem_id = $_GET['mid'];

// Fetch the fullname and member_id from activity_logs
$stmt = $con->prepare("SELECT fullname, member_id FROM activity_logs WHERE member_id = ?");
$stmt->bind_param("i", $mem_id);
$stmt->execute();
$stmt->bind_result($fullname, $member_id);
$stmt->fetch();
$stmt->close();

if ($fullname && $member_id) {
    // Prepare to insert logout data
    $logout_time = date('Y-m-d H:i:s');  // Get the current date and time
    $status = 'logged_out';

    // Insert the logout information into activity_logs
    $insert_stmt = $con->prepare("INSERT INTO activity_logs (fullname, member_id, logout_time, status) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $fullname, $mem_id, $logout_time, $status);
    
    if ($insert_stmt->execute()) {
        // Success - You can add additional code here if needed
    } else {
        // Handle error
        echo "Error: " . $con->error;
    }

    $insert_stmt->close();
}

// Close the connection
$con->close();

// Destroy the session and redirect to login page
$_SESSION = array();
session_destroy();

header("Location: index.php");
exit;
