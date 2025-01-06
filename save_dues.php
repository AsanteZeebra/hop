<?php
include_once('database_connection.php');

// Retrieve and escape user inputs
$fullname = mysqli_real_escape_string($con, $_POST['member_name']);
$member_id = mysqli_real_escape_string($con, $_POST['member_id']);
$department = mysqli_real_escape_string($con, $_POST['department']);
$years = $_POST['year'];
$months = $_POST['month'];
$amounts = $_POST['amount'];

$status = "Paid";
$date_created = date("Y-m-d"); // Updated date format

foreach ($years as $index => $year) {
    $year = mysqli_real_escape_string($con, $year);
    $month_paid = mysqli_real_escape_string($con, $months[$index]);
    $amount = mysqli_real_escape_string($con, $amounts[$index]);

    // Check if the record already exists
    $sqlc = "SELECT * FROM dues WHERE member_id=? AND month=? AND year=? AND department=?";
    $stmt = $con->prepare($sqlc);
    $stmt->bind_param("ssss", $member_id, $month_paid, $year, $department);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $upd = "UPDATE dues SET amount=?,  status=? WHERE member_id=? AND month=? AND year=? AND department=?";
        $stmt = $con->prepare($upd);
        $stmt->bind_param("ssssss", $amount,  $status, $member_id, $month_paid, $year, $department);
        if ($stmt->execute()) {
            echo "Record Updated Successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        // Insert new record
        $sql = "INSERT INTO dues (member_id, fullname, amount, department, month, year, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssss", $member_id, $fullname, $amount, $department, $month_paid, $year, $date_created, $status);
        if ($stmt->execute()) {
            echo 'Payment Recorded Successfully';
        } else {
            echo "Error recording payment: " . $stmt->error;
        }
    }
}

// Close statement and connection
$stmt->close();
$con->close();
?>