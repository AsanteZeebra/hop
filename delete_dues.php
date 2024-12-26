<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['member_id'], $_POST['month'], $_POST['year'])) {
    $idd = mysqli_real_escape_string($con, $_POST['member_id']); // Escape input to prevent SQL injection
    $month = mysqli_real_escape_string($con, $_POST['month']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $department = mysqli_real_escape_string($con, $_POST['department']);

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM dues WHERE member_id = ? AND month = ? AND year = ? AND department = '$department'");
    $stmt->bind_param("sss", $idd, $month, $year); // Bind parameters (s = string)

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

// Close the database connection
$con->close();
?>
