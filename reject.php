<?php
include_once('database_connection.php');

$ref = $_POST['refer'];

$status = "Rejected";

$sql ="UPDATE exepenses SET status='$status' WHERE transaction_id='$ref'";
$execute = mysqli_query($con,$sql);
if($execute === true){
    echo "Decision Saved Successfully";
}else{
    mysqli_error($con);
}

?>