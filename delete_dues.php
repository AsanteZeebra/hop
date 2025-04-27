<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['month'], $_POST['year'])) {
    $month = trim($_POST['month']);
    $year = trim($_POST['year']);

    // Validate inputs
    if (!empty($month) && !empty($year) && ctype_digit($year) && strlen($year) === 4) {
        // Prepare the SQL statement
        $stmt = $con->prepare("DELETE FROM dues WHERE month = ? AND year = ?");
        $stmt->bind_param("ss", $month, $year);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo htmlspecialchars("$month $year Transaction Deleted Successfully");
            } else {
                echo "No matching record found to delete.";
            }
        } else {
            // Output error if execution fails
            echo "Error: " . htmlspecialchars($stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Invalid input. Ensure the year is a 4-digit number.";
    }
} else {
    echo "Error: Missing required data (month and year).";
}

// Close the database connection
$con->close();
?>