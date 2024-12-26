<?php 
include_once('database_connection.php');

$fullname = mysqli_real_escape_string($con,$_POST['fullname']);
$member_id = mysqli_real_escape_string($con,$_POST['member_id']);
$department = mysqli_real_escape_string($con,$_POST['department']);


$sql = "UPDATE members SET department='$department',status='Active' WHERE member_id='$member_id'";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo "Move Success";
}else{
    mysqli_error($con);
}


?>