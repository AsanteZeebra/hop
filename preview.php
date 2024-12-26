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
  <title>Youth Reports</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="youth_dashboard.php" class="nav-link">Home</a>
      </li>
    
    </ul>

 
  </nav>
  <!-- /.navbar -->
  <?php include_once('youth_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">report</li>
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
    <h4><?php echo $_POST['status'] ?> Dues From: <?php $date = date_create($_POST['from']); echo date_format($date,"Y-M-jS") ?>     To: <?php $date = date_create($_POST['to']); echo date_format($date,"Y-M-jS") ?></h4>
         
      <table class="table table-hover">
        <thead>
          <tr style="text-align: center;">
          
            <th>Month</th>
            <th>Year</th>
            <th>Status</th>
            <th>Payment_count</th>
            <th>Amount(¢)</th>
           
          </tr>
        </thead>
        <tbody>
        <?php
                 
                 $date = date_create($_POST['from']); 
                 $from = date_format($date,"Y-M-jS");

                 $date1 = date_create($_POST['to']); 
                 $to = date_format($date,"Y-M-jS");
               
               
                 $status = $_POST['status'];

                 

                  $sql = "SELECT month,year,status, SUM(amount) AS total, COUNT(month) AS months from  youth_warefare WHERE date_created BETWEEN '$from' AND '$to' AND status = '$status' GROUP BY month,year";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                  
                    $month = $row['month'];
                    $year   = $row['year'];
                    $amount = $row['total'];
                    $status = $row['status'];
                    $months = $row['months'];
                      
           
                  ?>
          <tr style="text-align: center;">
            <td><?php echo $month; ?></td>
            <td><?php echo $year; ?></td>
            <?php 
            if($status === "Paid"){
              echo"<td><span class='badge badge-success'>Paid</span></td>";
            }else{
              echo"<td><span class='badge badge-danger'>Unpaid</span></td>";
            }
            ?>
            <td><?php echo $months; ?></td>
            <td><b><?php echo number_format($amount,2) ?></b></td>
          </tr>
        </tbody>
        <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
      </table>
<br>
<br>

     <div class="col-6" style="margin-left: 900px;">
   
     <table class="table" style="width: 50%; font-weight: bold;">
     <?php
                 
                 $date = date_create($_POST['from']); 
                 $from = date_format($date,"Y-M-jS");

                 $date1 = date_create($_POST['to']); 
                 $to = date_format($date,"Y-M-jS");
               
               
                 $status = $_POST['status'];

                 

                  $sql = "SELECT month,year,status, SUM(amount) AS total, COUNT(month) AS months from  youth_warefare WHERE date_created BETWEEN '$from' AND '$to' AND status = '$status'";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                  
                   $total = $row['total'];
                   $count = $row['months'];
                      
           
                  ?>
        <tr style="text-align: center;">
          <td>Total Amount(¢):</td>
          <td><?php echo number_format($total,2); ?></td>
         
        </tr>
       
        <tr style="text-align: center;">
          <td>Payments Count:</td>
          <td><?php echo $count; ?></td>
         
        </tr>
        <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
      </table>
     </div>

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


</body>
</html>
