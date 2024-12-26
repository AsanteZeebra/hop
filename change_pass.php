<?php
include_once('database_connection.php');

// Check if input fields are set
if (isset($_POST['member_id']) && isset($_POST['password'])) {
    $member_id = $_POST['member_id'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement using a simplified syntax
    $query = "UPDATE account SET password = ? WHERE member_id = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $hashed_password, $member_id);
        
        if ($stmt->execute()) {
            echo "Password updated successfully";
        } else {
            error_log("Error executing query: " . $stmt->error);
            echo "An error occurred. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    } else {
        error_log("Error preparing statement: " . $con->error);
        echo "An error occurred. Please try again later.";
    }

    // Close the database connection
    $con->close();
} else {
    echo "Invalid input.";
}
?>
