<?php
include_once('database_connection.php');

// Function to validate input
function validate_input($data)
{
  return htmlspecialchars(trim($data));
}

$category = validate_input($_POST['category']);
$date = validate_input($_POST['date']);
$amount = validate_input($_POST['amount']);
$details = validate_input($_POST['details']);
$benefit = validate_input($_POST['benefit']);
$reference_id = validate_input($_POST['idd']);
$cheque_no = validate_input($_POST['cheque']);
$department = validate_input($_POST['department']);
$type = validate_input($_POST['type']);

$month = date('F');
$year = date('Y');
$date_created = date("Y-m-j");
$idd = mt_rand(5555, 10000);
$transaction_id = "WRF" . $idd . $year;

$status = "Pending";

try {
  // Check for duplicate transaction ID
  $stmt = $con->prepare("SELECT * FROM exepenses WHERE transaction_id = ?");
  $stmt->bind_param("s", $transaction_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "Transaction already exists";
  } else {
    // Insert new expense
    $insert_stmt = $con->prepare("
            INSERT INTO exepenses (
                transaction_id, unique_reference, category, expense_type, 
                beneficiary, cheque_number, amount, details, department, 
                status, date, month, year, date_created
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
    $insert_stmt->bind_param(
      "ssssssisssssss",
      $transaction_id,
      $reference_id,
      $category,
      $type,
      $benefit,
      $cheque_no,
      $amount,
      $details,
      $department,
      $status,
      $date,
      $month,
      $year,
      $date_created
    );

    if ($insert_stmt->execute()) {
      echo 'Transaction Sent for Validation';
    } else {
      echo "Error: " . $insert_stmt->error;
    }
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

// Close connections
$stmt->close();
$insert_stmt->close();
$con->close();
?>