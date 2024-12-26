<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['refer'])) {
    $ref = mysqli_real_escape_string($con, $_POST['refer']); // Escape input to prevent SQL injection
    $status = "Approved";

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("UPDATE exepenses SET status = ? WHERE transaction_id = ?");
    $stmt->bind_param("ss", $status, $ref); // Bind parameters (s = string)

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Request Approved";
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
