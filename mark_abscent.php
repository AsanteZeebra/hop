<?php 
include_once('database_connection.php');

// Fetch and sanitize POST data
$member_name = mysqli_real_escape_string($con, $_POST['member_name']);
$member_id = mysqli_real_escape_string($con, $_POST['member_id']);
$month = date('M');
$week = date('W');
$year = date('Y');
$date_created = date("Y-M-jS");
$status = "Abscent";

// Check if the attendance record already exists
$sqlc = "SELECT * FROM attendance WHERE member_id='$member_id' AND month='$month' AND year='$year' AND week='$week'";
$run = mysqli_query($con, $sqlc);

if (mysqli_num_rows($run) > 0) {
    // Update existing attendance record
    $query = "UPDATE attendance 
              SET status='$status' 
              WHERE member_id='$member_id' AND month='$month' AND year='$year' AND week='$week' AND date_created='$date_created'";
    $pros = mysqli_query($con, $query);
    
    if ($pros) {
        echo "Attendance Updated";
    } else {
        echo "Error: " . mysqli_error($con);
    }

} else {
    // Insert new attendance record
    $sql = "INSERT INTO attendance (fullname, member_id, week, month, year, status, date_created) 
            VALUES ('$member_name', '$member_id', '$week', '$month', '$year', '$status', '$date_created')";
    $execute = mysqli_query($con, $sql);
    
    if ($execute) {
        echo "Attendance Recorded";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
