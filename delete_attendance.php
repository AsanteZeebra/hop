<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['idd'], $_POST['mm'], $_POST['yy'], $_POST['ww'])) {
    $idd = mysqli_real_escape_string($con, $_POST['idd']); // Escape input to prevent SQL injection
    $month = mysqli_real_escape_string($con, $_POST['mm']);
    $year = mysqli_real_escape_string($con, $_POST['yy']);
    $week = mysqli_real_escape_string($con, $_POST['ww']);

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM attendance WHERE member_id = ? AND month = ? AND year = ? AND week = ?");
    $stmt->bind_param("ssss", $idd, $month, $year, $week); // Bind parameters (s = string)

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Attendance Record Deleted";
        } else {
            echo "No record found to delete";
        }
    } else {
        // Output error if execution fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Missing parameters.";
}

// Close the database connection
$con->close();
?>
