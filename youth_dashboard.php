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
    <img class="animation__wobble" src="dist/img/hop1.png" alt="HOP LOGO" height="60" width="60">
  </div>

  <!-- Navbar -->
  <?php include_once('navbar_youth.php'); ?>
  <!-- /.navbar -->


  <!-- Sidebar -->
<?php include_once('youth_sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Youth Fellowship</h1>
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
                <span class="info-box-text">Youth list</span>
                <?php
                    $sql = "SELECT COUNT(*) AS total FROM members WHERE  age between 13 AND 28 AND marital_status='single'";
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
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE department='Youth' AND status='Rejected' ";
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
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE department='Youth' AND status='Approved' ";
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
                <span class="info-box-text">Warefare Total(¢)</span>

               <?php
                    $sql = "SELECT SUM(amount) AS total FROM dues WHERE department='Youth' AND status='Paid' ";
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

$query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Youth' GROUP BY month ");

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

                        $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND department='Youth' AND status='Paid' GROUP BY month  ");

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
                <div class="row">
                 
                <a href="report_today_youth.php?mid=<?php echo $_GET['mid']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Today's Report</a>

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
<?php include_once('mens_chart.php'); ?>


</body>
</html>
