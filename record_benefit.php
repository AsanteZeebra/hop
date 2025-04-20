<?php
include_once('database_connection.php');

// Enable mysqli exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Function to validate input
function validate_input($data)
{
    return htmlspecialchars(trim($data));
}

$fullname = validate_input($_POST['name']);
$member_id = validate_input($_POST['member_id']);
$amount = validate_input($_POST['amount']);
$benefit = validate_input($_POST['benefit']);
$telephone = validate_input($_POST['telephone']);
$address = validate_input($_POST['address']);
$comment = validate_input($_POST['comment']);
$status = validate_input($_POST['status']);
$department = validate_input($_POST['department']);
$approved_by = validate_input($_POST['approved_by']);

// Validate numeric fields
if (!is_numeric($amount)) {
    die("Invalid amount");
}
if (!is_numeric($telephone)) {
    die("Invalid telephone number");
}

$year = date('Y'); // Define the year
$idd = mt_rand(9888, 90000); // Generate a random number
$transaction_id = "HBT" . $idd . $year;

try {
    // Check for duplicate transaction ID or telephone
    $stmt = $con->prepare("SELECT * FROM benefits WHERE transaction_id = ? OR telephone = ?");
    $stmt->bind_param("ss", $transaction_id, $telephone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A transaction with this ID or telephone number already exists.";
    } else {
        // Insert new benefit
        $insert_stmt = $con->prepare("
            INSERT INTO benefits (
                transaction_id, fullname, member_id, telephone, address, benefit_type, department,
                amount, comment, status,approved_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
        ");
        $insert_stmt->bind_param(
            "sssssssssss", // 10 placeholders
            $transaction_id,
            $fullname,
            $member_id,
            $telephone,
            $address,
            $benefit,
            $department,
            $amount,
            $comment, // Add the missing $comment variable
            $status,
            $approved_by
        );

        if ($insert_stmt->execute()) {
            echo "$fullname's Transaction Recorded successfully!";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close connections
if (isset($stmt)) {
    $stmt->close();
}
if (isset($insert_stmt)) {
    $insert_stmt->close();
}
$con->close();
?>