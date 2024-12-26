
<?php


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
  <title>Warefare | Manage Warefare</title>
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
            <h1>Manage Warefare</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">manage_warefare</li>
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
       
    <table class='table table-hover' id="example1">
        
            <thead>
               <tr>
                <th>#ID</th>
                <th>Fullname</th>
                <th>Month</th>
                <th>Year</th>
                <th>Week</th>
                <th>Date</th>
                <th>Amount(¢)</th>
                <th style='text-align:center;'><i class='fa fa-bars'></i></th>
               </tr>
            </thead>
            <tbody>
            <?php
                  include_once('database_connection.php');
                  
                  $sql = "SELECT * FROM dues";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                     $member_id = $row['member_id'];
                     $fullname = $row['fullname'];
                     $month = $row['month'];
                     $year = $row['year'];
                     $week = $row['week'];
                     $amount = $row['amount'];     
                     $date_paid = $row['date_paid'];             
           
                  ?>
                <tr>
                    <td><a href="#"><?php echo $member_id ?></a></td>
                    <td><?php echo $fullname ?></td>
                    <td><?php echo $month?></td>
                    <td><?php echo $year ?></td>
                    <td><?php echo $week ?></td>
                  <td><?php echo $date_paid ?></td>
                    <td><?php echo number_format($amount,2) ?></td>
                    <td style='text-align:center;'><a href="#" class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a> </td>
                </tr>
               
                <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
            </tbody>
        
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


</body>
</html>
