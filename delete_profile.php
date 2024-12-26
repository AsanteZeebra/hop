<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['member_id'])) {
    $idd = $_POST['member_id'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM members WHERE member_id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    // Bind the parameter (s = string)
    $stmt->bind_param("s", $idd);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Successfully Deleted";
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
    echo "Error: 'member_id' parameter not set.";
}

// Close the database connection
$con->close();
?>
