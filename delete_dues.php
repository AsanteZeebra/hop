<?php
include_once('database_connection.php');

// Check if POST data is set
$idd = mysqli_real_escape_string($con, $_POST['idd']);
    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM dues WHERE id = ? ");
    $stmt->bind_param("s", $idd); // Bind parameters (s = string)

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


// Close the database connection
$con->close();
?>
