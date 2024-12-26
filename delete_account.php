<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['rid'])) {
    $idd = mysqli_real_escape_string($con, $_POST['rid']); // Escape input to prevent SQL injection
  
    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM account WHERE member_id = ?");
    $stmt->bind_param("s", $idd); // Bind parameters (s = string)

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Account Deleted Successfully";
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

// Close the database connection
$con->close();
?>
