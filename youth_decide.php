<?php
include_once('database_connection.php');

// Retrieve and sanitize POST data
$ref = $_POST['refer'];
$status = "Approved";

// Use prepared statements to prevent SQL injection
$sql = "UPDATE youth_expenses SET status=? WHERE transaction_id=?";
$stmt = mysqli_prepare($con, $sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $status, $ref);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Request Approved";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
