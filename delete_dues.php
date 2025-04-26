<?php
include_once('database_connection.php');

// Check if POST data is set
if (isset($_POST['idd'])) {
    $idd = (int) $_POST['idd']; // Cast to integer directly (safe)

    // Prepare the SQL statement
    $stmt = $con->prepare("DELETE FROM dues WHERE id = ?");
    $stmt->bind_param("i", $idd); // 'i' for integer

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
    echo "Error: Missing ID.";
}

// Close the database connection
$con->close();
?>
