<?php 
include_once('database_connection.php');

// Function to sanitize input
function sanitize_input($con, $data) {
    return mysqli_real_escape_string($con, trim($data));
}

// Sanitize and hash inputs
$fullname = sanitize_input($con, $_POST['fullname']);
$member_id = sanitize_input($con, $_POST['member_id']);
$department = sanitize_input($con, $_POST['department']);
$role = sanitize_input($con, $_POST['role']);
$password = password_hash(sanitize_input($con, $_POST['password']), PASSWORD_DEFAULT); // Secure password hashing
$status = "Active";
$month = date('F');
$year = date('Y');
$date_created = date("Y-m-d H:i:s"); // Use a standard datetime format

// Check if the account already exists
$sqlc = "SELECT * FROM account WHERE member_id = ?";
$stmt = mysqli_prepare($con, $sqlc);
mysqli_stmt_bind_param($stmt, 's', $member_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "Account: $member_id Already Exists";
} else {
    // Prepare the insert statement
    $sql = "INSERT INTO account (fullname, member_id, department, role, password, month, year, status, date_created) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssss', $fullname, $member_id, $department, $role, $password, $month, $year, $status, $date_created);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Account Created Successfully";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
