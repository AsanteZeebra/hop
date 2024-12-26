<?php 
include_once('database_connection.php');

$member_name = mysqli_real_escape_string($con,$_POST['member_name']);
$member_id = mysqli_real_escape_string($con,$_POST['member_id']);
$tittle = mysqli_real_escape_string($con,$_POST['tit']);
$message = mysqli_real_escape_string($con,$_POST['message']);
$department = "Main Church";
$report_id = uniqid();
$month = date('F');
$year = date('Y');
$date_created = date("Y-M-jS");

$sql = "INSERT INTO reports(report_id,member_id,fullname,department,message,tittle,month,year,date_created) VALUES('$report_id','$member_id','$member_name','$department','$message','$tittle','$month','$year','$date_created')";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo "Report submitted Successfully.";
}else{
    mysqli_error($con);
}



?>