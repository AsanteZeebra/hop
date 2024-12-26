<?php 
include_once('database_connection.php');

$fullname = mysqli_real_escape_string($con,$_POST['member_name']);
$member_id = mysqli_real_escape_string($con,$_POST['member_id']);
$year = mysqli_real_escape_string($con,$_POST['year']);
$amount = mysqli_real_escape_string($con,$_POST['amount']);
$month_paid = mysqli_real_escape_string($con,$_POST['month']);
$status = "Paid";
//$month = date('F');
//$year = date('Y');
$date_created = date("Y-M-jS");
$department = 'Women';




$sqlc = " SELECT *  FROM dues WHERE  member_id='$member_id' and month='$month_paid' and year='$year' AND department='$department' ";
$run = mysqli_query($con, $sqlc);
if (mysqli_num_rows($run) > 0) {
   
$upd = "UPDATE dues SET amount='$amount',date_created='$date_created',status='Paid' WHERE member_id='$member_id' AND month='$month_paid' AND year='$year' AND department='$department' ";
$ex = mysqli_query($con,$upd);
if($ex === true){
  echo "Record Updated Successfully";
}

} else {
$sql ="INSERT INTO dues(member_id,fullname,amount,department,month,year,date_created,status)VALUES('$member_id','$fullname','$amount','$department','$month_paid','$year','$date_created','$status')";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo 'Payment Recorded Successfully';
}else{
    echo mysqli_error($con);
}
}

?>