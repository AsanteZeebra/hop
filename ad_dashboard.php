<?php
include_once('database_connection.php');


include_once('load_session.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome|HOP|Dashboard|</title>

 <?php include_once("head.php"); ?>
</head>
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/hop1.png" alt="logo" height="60" width="60">
  </div>

  <!-- Navbar -->
   <?php 
   $department = $_GET['dept'];

   switch ($department) {
    case 'Men':
        include_once('navbar_men.php'); 
        break;
    case 'Main':
        include_once('navbar_general.php'); 
        break;
    case 'Women':
    include_once('navbar_women.php'); 
        break;
        case 'Youth':
         include_once('navbar_youth.php'); 
            break;
    default:
        echo 'Departments not found.';
        break;
   }
   ?>
 
  <!-- /.navbar -->


  <!-- Sidebar -->
<?php 
$department = $_GET['dept'];
switch ($department) {
    case 'Men':
       include_once('mens_sidebar.php');
        break;
    case 'Main':
       include_once('general_sidebar.php');
        break;
    case 'Youth':
        include_once('youth_sidebar.php');
        break;
    case 'Women':
        include_once('womens_sidebar.php');
        break;
    default:
        # code...
        break;
}





?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $_GET['dept'] ?>'s Department</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">  
          <div class="col-12 col-sm-6 col-md-3">
           <a href="#" style="color:black">
           <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Members</span>
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT COUNT(DISTINCT member_id) AS total FROM dues WHERE department='$department' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number"><?php echo $count; ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3"> 
           <a href="#" style="color:black">
           <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Rejected Expenses</span>
                
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE department='$department' AND status='Rejected' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <a href="#" style="color:black">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Approved Expenses</span>
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE department='$department' AND status='Approved' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
           
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
        <a href="#" style="color:black">
        <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-file-invoice" style="color:white"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Welfare Total(¢)</span>

               <?php
               $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM dues WHERE department='$department' AND status='Paid' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

        </a>  
        </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                  <div class="btn-group">
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                   

                    <div class="chart">
                   
                    <?php


$year = date('Y');
$department = $_GET['dept'];

$query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='$department' GROUP BY month ");

foreach ($query as $row) {


  $sy[] = $row['ms'];

  $sam[] = $row['sam'];




}
?>

                      <canvas id="dot" height="250" style="height: 250px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                 
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                    </p>
                        <?php

                        $year = date('Y');
                        $department = $_GET['dept'];
                        $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND department='$department' AND status='Paid' GROUP BY month  ");

                        foreach ($query as $row) {



                          $month[] = $row['ms'];
                          $tot[] = $row['sam'];

                        }
                        ?>
                      <canvas id="line" height="200"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                
                </div>
                <!-- /.row -->
            
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
         

          <div class="col-md-4">
          
          
            


            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php include_once('footer.php'); ?>
</div>
<!-- ./wrapper -->

<?php include_once('script.php'); ?>
<?php include_once('mens_chart.php'); ?>


</body>
</html>
