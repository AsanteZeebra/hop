<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['refer'])) {
    $idd = $_POST['refer'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM exepenses WHERE id = ? AND department = 'Youth'");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    // Bind the parameter (s = string)
    $stmt->bind_param("s", $idd);

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
    echo "Error: 'refer' parameter not set.";
}

// Close the database connection
$con->close();
?>
