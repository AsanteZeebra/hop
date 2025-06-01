<?php
include_once('database_connection.php'); // Include your database connection filed
$updateAgeSql = "
    UPDATE members
    SET age = TIMESTAMPDIFF(YEAR, dob, CURDATE())
";
if ($con->query($updateAgeSql) === TRUE) {
    echo "Ages updated successfully.<br>";
} else {
    echo "Error updating ages: " . $con->error . "<br>";
}

// Update status to 'exempted' for members aged 70 and above
$updateStatusSql = "
    UPDATE members
    SET welfare_status = 'exempted'
    WHERE age >= 70
";
if ($con->query($updateStatusSql) === TRUE) {
    echo "Status updated for members aged 70 and above.";
} else {
    echo "Error updating status: " . $con->error;
}

$con->close();
?>
