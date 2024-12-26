<?php 
include_once('database_connection.php');

// Fetch and sanitize POST data
$member_name = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
$member_id = htmlspecialchars($_POST['member_id'], ENT_QUOTES, 'UTF-8');
$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
$reason = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8');

$month = date('F');
$fullweek = date('W');
$year = date('Y');
$date_created = date("Y-m-jS");
$week ="week$fullweek";

// Prepare SQL statement to check if the record exists
$sqlc = "SELECT * FROM attendance WHERE member_id=? AND month=? AND year=? AND week=?";
$stmt = $con->prepare($sqlc);
$stmt->bind_param('ssss', $member_id, $month, $year, $week);
$stmt->execute();
$run = $stmt->get_result();

if ($run->num_rows > 0) {
    // Update existing attendance record
    $query = "UPDATE attendance SET status=?,reason=?,date_created=? WHERE member_id=? AND month=? AND year=? AND week=?";
    $stmt_update = $con->prepare($query);
    $stmt_update->bind_param('sssssss', $status,$reason,$date_created, $member_id, $month, $year, $week);
    $pros = $stmt_update->execute();
    
    if ($pros) {
        echo "Attendance Updated";
    } else {
        echo "Error: " . $con->error;
    }

} else {
    // Insert new attendance record
    $sql = "INSERT INTO attendance (fullname, member_id, week, month, year, status,reason, date_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt_insert = $con->prepare($sql);
    $stmt_insert->bind_param('sssssss', $member_name, $member_id, $week, $month, $year, $status,$reason, $date_created);
    $execute = $stmt_insert->execute();
    
    if ($execute) {
        echo "Attendance Recorded";
    } else {
        echo "Error: " . $con->error;
    }
}

// Close prepared statements
$stmt->close();
if (isset($stmt_update)) $stmt_update->close();
if (isset($stmt_insert)) $stmt_insert->close();
$con->close();

