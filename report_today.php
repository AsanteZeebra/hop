<?php 
include_once('database_connection.php');


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}
// Check if last activity was set
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3600) {
  session_unset(); // unset $_SESSION variable 
  session_destroy(); // destroy session data in storage
  header("Refresh:10"); //refresh
  header("Location: index.php"); // redirect to login page
 }
 $_SESSION['last_activity'] = time(); // update last activity time stamp
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Today's report | Welfare </title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php include_once('navbar.php'); ?>
  <!-- /.navbar -->
  <?php include_once('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Welfare</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Welfare</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card">
    <div class="card-body">
<center>
<img src="dist/img/hop1.png" alt="hop-logo" style="width:180px; height:180px; ">  <br>  
<b style="font-size:30px">General Welfare Report</b> <br>
<b style="font-size:20px"><?php echo date("Y-M-jS"); ?> Week <?php echo date("W"); ?> </b> 
<hr style="background-color:black">
</center>
<br>
    <table class="table" >
        <thead>
           <tr>
           <th>#ID</th>
            <th>Name</th>
            <th>Month</th>
            <th>Year</th>
            <th>Amount</th>
            <th>Dept.</th>
            <th>Paid_on</th>
           </tr>
    </thead>
    <tbody>
    <?php
                $today =  date("Y-M-jS"); 
                  
                 $sql = "SELECT * FROM dues WHERE status = 'Paid' AND date_created='$today' ";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['amount'];
                   $member_id = $row['member_id'];
                   $fullname = $row['fullname'];
                   $month = $row['month'];
                   $year = $row['year'];
                   $paid_on = $row['date_created'];
                   $department = $row['department'];
                 
                 ?>
<tr>
    <td><?php echo $member_id ?></td>
    <td><?php echo $fullname ?></td>
    <td><?php echo $month ?></td>
    <td><?php echo $year ?></td>
    <td><?php echo number_format($amount,2) ?></td>
    <td><?php echo $department; ?></td>
  <td><?php echo $paid_on ?></td>
</tr>
<?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
    </tbody>
   
    </table>
<br>

    <table class="table" style="float: Right; width:30%">
        <tr>
        <?php
                $today =  date("Y-M-jS"); 
                  
                 $sql = "SELECT SUM(amount) AS total FROM dues WHERE status = 'Paid' AND date_created='$today' ";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['total'];

                 ?>
            <td><b style="font-size: 25px">Total(¢): <?php echo  number_format($amount,2) ?></b> </td>
            <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
        </tr>
        <tr>
            <td></td>
        </tr>
       
    </table>
      </div>
  </div>
</div>
  </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include_once('footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->



<?php include_once("script.php"); ?>

<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
