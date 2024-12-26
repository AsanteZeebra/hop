<?php 
include_once('database_connection.php');

$member_name = mysqli_real_escape_string($con,$_POST['member_name']);
$tittle = mysqli_real_escape_string($con,$_POST['tit']);
$message = mysqli_real_escape_string($con,$_POST['message']);
$department = "Main Church";
$report_id = uniqid();
$month = date('F');
$year = date('Y');
$date_created = date("Y-M-jS");
$status = "Active";

$sql = "INSERT INTO announcement(announcement_id,tittle,description,department,month,year,status,date_created,created_by) VALUES('$report_id','$tittle','$message','$department','$month','$year','$status','$date_created','$member_name')";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo "Announcement submitted Successfully.";
}else{
    mysqli_error($con);
}


