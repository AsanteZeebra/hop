<?php
if (!empty($_FILES)) {
    // Include the database configuration file 
    include_once('database_connection.php');

    // File path configuration 
    $uploadDir = "uploads/";
    $fileName = basename($_FILES['file']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // Sanitize input to prevent SQL injection
    $idd = mysqli_real_escape_string($con, $_POST['memid']);

    // Check if the photo already exists
    $sqlc = "SELECT * FROM members WHERE member_id = ?";
    $stmt = mysqli_prepare($con, $sqlc);
    mysqli_stmt_bind_param($stmt, 's', $idd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Photo exists, update the existing record
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
            // Update file information in the database using prepared statements
            $sql = "UPDATE members SET file_name = ? WHERE member_id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'ss', $fileName, $idd);
            $update = mysqli_stmt_execute($stmt);

            if ($update) {
                echo "Photo Uploaded";
            } else {
                echo mysqli_error($con);
            }
        }
    } else {
        // Photo does not exist
       echo "Member details do not exist";
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
