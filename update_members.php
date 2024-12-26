<?php 
include_once('database_connection.php');

$fullname = mysqli_real_escape_string($con, $_POST['fullname']);
$altercall = mysqli_real_escape_string($con, $_POST['altercall']);
$birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$marital_status = mysqli_real_escape_string($con, $_POST['marital']);
$occupation = mysqli_real_escape_string($con, $_POST['occupation']);
$telephone = mysqli_real_escape_string($con, $_POST['telephone']);
$age = mysqli_real_escape_string($con, $_POST['age']);
$spouse = mysqli_real_escape_string($con, $_POST['spouse']);
$children = mysqli_real_escape_string($con, $_POST['child']);
$city = mysqli_real_escape_string($con, $_POST['city']);
$region = mysqli_real_escape_string($con, $_POST['region']);
$residence = mysqli_real_escape_string($con, $_POST['residence']);
$postal_address = mysqli_real_escape_string($con, $_POST['postal']);
$next_of_kin = mysqli_real_escape_string($con, $_POST['nextofkin']);
$position = mysqli_real_escape_string($con, $_POST['position']);
$member_id = mysqli_real_escape_string($con, $_POST['member_id']);

// Use prepared statements to avoid SQL injection
$sql = "UPDATE members SET fullname='$fullname',alter_call='$altercall',dob='$birthdate',gender='$gender',marital_status='$marital_status',occupation='$occupation',
telephone='$telephone',age='$age',spouse='$spouse',number_of_children='$children',city='$city',region='$region',residense_address='$residence',postal_address='$postal_address',next_of_kin='$next_of_kin',position='$position' WHERE member_id='$member_id'";

$execute= mysqli_query($con, $sql);
if ($execute === true) {
    echo "Record updated successfully";
}else {
    mysqli_error($con);
}

