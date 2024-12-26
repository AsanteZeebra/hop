<?php 
include_once('database_connection.php');

$category = mysqli_real_escape_string($con, $_POST['category']);
$date = mysqli_real_escape_string($con, $_POST['date']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$details = mysqli_real_escape_string($con, $_POST['details']);
$month = date('F');
$year = date('Y');
$date_created = date("Y-M-jS");
$idd = mt_rand(5555,10000);
$benefit = mysqli_real_escape_string($con, $_POST['benefit']);
$transaction_id = "WRF".$idd.$year;
$transaction_date = mysqli_real_escape_string($con, $_POST['date']);
$reference_id = mysqli_real_escape_string($con,$_POST['idd']);
$status = "Pending";
$type = mysqli_real_escape_string($con,$_POST['extype']);
$cheque_no = mysqli_real_escape_string($con,$_POST['cheque_no']);
$department = "Women";


$sqlc = " SELECT *  FROM exepenses WHERE transaction_id='$transaction_id'";
$run = mysqli_query($con, $sqlc);
if (mysqli_num_rows($run) === true) {
   
  echo "Transaction already Exist";
} else {
$sql ="INSERT INTO exepenses (transaction_id,unique_reference,cheque_number,category,expense_type,beneficiary,amount,details,department,status,date,month,year,date_created)VALUES('$transaction_id','$reference_id','$cheque_no','$category','$type','$benefit','$amount','$details','$department','$status','$transaction_date','$month','$year','$date_created')";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo 'Transaction Sent for Validation';
}else{
    echo mysqli_error($con);
}
}
?>