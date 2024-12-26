<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['member_id'], $_POST['month'], $_POST['year'])) {
    $idd = $_POST['member_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM dues WHERE member_id = ? AND month = ? AND year = ? AND department = 'Youth'");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    // Bind the parameters (s = string)
    $stmt->bind_param("sss", $idd, $month, $year);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Transaction Deleted Successfully";
        } else {
            echo "No matching record found to delete";
        }
    } else {
        // Output error if execution fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Missing required parameters.";
}

// Close the database 
