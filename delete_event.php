<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['refer'])) {
    $idd = mysqli_real_escape_string($con, $_POST['refer']); // Escape input to prevent SQL injection

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("DELETE FROM calendar_event_master WHERE event_id = ?");
    $stmt->bind_param("s", $idd); // Bind parameter (s = string)

    // Execute the statement and check for success
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Event Deleted Successfully";
        } else {
            echo "No event found with the specified ID";
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
