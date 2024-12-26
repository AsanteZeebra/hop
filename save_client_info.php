<?php 
include_once('database_connection.php');

$fullname = mysqli_real_escape_string($con,$_POST['fullname']);
$altercall = mysqli_real_escape_string($con,$_POST['altercall']);
$birthdate = mysqli_real_escape_string($con,$_POST['birthdate']);
$gender = mysqli_real_escape_string($con,$_POST['gender']);
$marital_status = mysqli_real_escape_string($con,$_POST['marital']);
 $occupation = mysqli_real_escape_string($con,$_POST['occupation']);
$telephone = mysqli_real_escape_string($con,$_POST['telephone']);
$age = mysqli_real_escape_string($con,$_POST['age']);
$spouse = mysqli_real_escape_string($con,$_POST['spouse']);
$children = mysqli_real_escape_string($con,$_POST['child']);
$city = mysqli_real_escape_string($con,$_POST['city']);
 $region = mysqli_real_escape_string($con,$_POST['region']);
 $residence = mysqli_real_escape_string($con,$_POST['residence']);
 $postal_address = mysqli_real_escape_string($con,$_POST['postal']);
 $next_of_kin = mysqli_real_escape_string($con,$_POST['nextofkin']);
$month = date('F');
$year = date('Y');
$date_created = date("Y-M-jS");
$status = "Active";
$position = "Member";
$amount ="0";

$idd = mt_rand(1111,9999);

$member_id = "TM".$idd.$year;

$amout = "0";

$dstatus = "Unpaid";

$sqlc = " SELECT *  FROM members WHERE fullname='$fullname' and telephone='$telephone' and dob='$birthdate'";
$run = mysqli_query($con, $sqlc);
if (mysqli_num_rows($run) > 0) {

  echo "Member Already Exist";
} else {

  
$sql = "INSERT INTO members(fullname,dob,age,alter_call,gender,marital_status,occupation,telephone,spouse,number_of_children,city,region,residense_address,postal_address,next_of_kin,member_id,position,status,month,year,date_created) VALUES 
('$fullname','$birthdate','$age','$altercall','$gender','$marital_status','$occupation','$telephone','$spouse','$children','$city','$region','$residence','$postal_address','$next_of_kin','$member_id','$position','$status','$month','$year','$date_created')";
$execute = mysqli_query($con,$sql);

$sql ="INSERT INTO dues(member_id,fullname,amount,month,year,status)VALUES('$member_id','$fullname','$amount','$month','$year','$dstatus')";
$execute = mysqli_query($con,$sql);
if($execute === true){
 
    echo "DATA SAVED SUCCESSFULLY";
}else{
    mysqli_error($con);
}
}

?>