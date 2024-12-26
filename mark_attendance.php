<?php 
include_once('database_connection.php');

// Fetch POST data and sanitize if necessary
$member_name = $_POST['member_name'];
$member_id = $_POST['member_id'];
$month = $_POST['month'];
$week = $_POST['week'];
$year = date('Y');
$date_created = date("Y-M-jS");
$status = $_POST['st'];

// Check if the attendance record already exists
$sqlc = "SELECT * FROM attendance WHERE member_id = ? AND month = ? AND year = ? AND week = ?";
$stmtc = $con->prepare($sqlc);
$stmtc->bind_param('ssss', $member_id, $month, $year, $week);
$stmtc->execute();
$run = $stmtc->get_result();

if ($run->num_rows > 0) {
    // Update existing attendance record
    $query = "UPDATE attendance SET status = ?, date_created = ? WHERE member_id = ? AND month = ? AND year = ? AND week = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssss', $status, $date_created, $member_id, $month, $year, $week);
    $pros = $stmt->execute();

    if ($pros) {
        echo "Attendance Updated";
    } else {
        echo "Error: " . $stmt->error;
    }

} else {
    // Insert new attendance record
    $sql = "INSERT INTO attendance (fullname, member_id, week, month, year, status, date_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssssss', $member_name, $member_id, $week, $month, $year, $status, $date_created);
    $execute = $stmt->execute();

    if ($execute) {
        echo "Attendance Recorded";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
