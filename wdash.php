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
    <img class="animation__wobble" src="dist/img/hop1.png" alt="hop logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     

    <li class="nav-item">
    <?php
                 
                  
                 $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' ";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['money'];
                 
                 ?>
      <b class="nav-link">Balance: ¢<?php echo number_format($amount,2) ?></b>
      <?php    }
                  } else {
                    echo "No Record Found!";
                  } ?>
      </li>
      
      <li class="nav-item">
        <a class="nav-link"  href="welfare_summary_report.php?mid=<?php echo $_GET['mid']; ?>" role="button">
        <i class="fa-solid fa-print"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link"  href="signout.php" role="button">
        <i class="fa-solid fa-arrow-right-from-bracket"></i> logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Sidebar -->
<?php include_once('welfare_sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Welfare</h1>
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
           <a href="welfare.php?mid=<?php echo $_GET['mid']; ?> && dept=Main" style="color:black">
           <div class="info-box">
              <span class="info-box-icon bg-info elevation-1">  <i class="fa-solid fa-hand-holding-hand"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">General Welfare</span>
                <?php
                 
                  
                  $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' AND department='Main' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $amount = $row['money'];
                  
                  ?>
                <span class="info-box-number">
               ¢<?php echo  number_format( $amount,2); ?>
                </span>
                <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
           <a href="welfare.php?mid=<?php echo $_GET['mid']; ?> && dept=Men" style="color:black">
           <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1">  <i class="fa-solid fa-user-tie"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Men's Welfare</span>

                <?php 
                  $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' AND department='Men' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $amount = $row['money'];
                  
                  ?>
                <span class="info-box-number">
               ¢<?php echo  number_format( $amount,2); ?>
                </span>
                <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
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
            <a href="welfare.php?mid=<?php echo $_GET['mid']; ?> && dept=Women" style="color:black">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1">  <i class="fa-regular fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Women's Welfare</span>

                <?php
                 
                  
                  $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' AND department='Women'";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $amount = $row['money'];
                  
                  ?>
                <span class="info-box-number">
               ¢<?php echo  number_format( $amount,2); ?>
                </span>
                <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
           
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
        <a href="welfare.php?mid=<?php echo $_GET['mid']; ?> && dept=Youth" style="color:black">
        <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">   <i class="fa-solid fa-people-roof"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Youth Welfare</span>
                <?php
                 
                  
                  $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' AND department='Youth' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $amount = $row['money'];
                  
                  ?>
                <span class="info-box-number">
               ¢<?php echo  number_format( $amount,2); ?>
                </span>
                <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
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
                <h5 class="card-title">Monthly Recap Report - <?php echo date('Y') ?></h5>

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
                    <p class="text-center">
                      <strong>Paid Welfare Statistics</strong>
                    </p>

                    <div class="chart">
                    <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Main' GROUP BY month ");

                          foreach ($query as $row) {


                            $sy[] = $row['ms'];

                            $sam[] = $row['sam'];




                          }
                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Men' GROUP BY month ");

                          foreach ($query as $row) {




                            $sam1[] = $row['sam'];


                          }

                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Women' GROUP BY month  ");

                          foreach ($query as $row) {




                            $sam2[] = $row['sam'];




                          }
                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Youth' GROUP BY month  ");

                          foreach ($query as $row) {




                            $sam3[] = $row['sam'];




                          }
                          ?>
                      <canvas id="dot" style="height: 220px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                  <div class="card">
             
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">Unpaid Welfare Statistics <?php echo date('Y') ?></p>
                    <div class="chart-responsive">

                    <?php

$year = date('Y');

$query = $con->query("SELECT department AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Unpaid' GROUP BY department  ");

foreach ($query as $row) {



  $month[] = $row['ms'];
  $tot[] = $row['sam'];




}
?>

                      <canvas id="line" height="180"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <!-- /.col -->
                
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
            
             
            </div>
            <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                 
                </div>
                <!-- /.row -->
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

<?php include_once('dashbaord_chart.php'); ?>
</body>
</html>
