<?php 
include_once('database_connection.php');


include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance|HOP|Dashboard|</title>

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
    
    </nav>
  <!-- /.navbar -->


  <!-- Sidebar -->
<?php include_once('att_sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Attendance</h1>
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
              <span class="info-box-icon bg-info elevation-1">  <i class="fa-solid fa-hand-holding-hand"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <?php
                 
                  
                  $sql = "SELECT COUNT(*) AS total FROM members";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $total = $row['total'];
                  
                  ?>
                <span class="info-box-number">
               <?php echo $total; ?>
                </span>
                <?php    }
                  } else {
                    echo "No Record Found!";
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
              <span class="info-box-icon bg-success elevation-1">  <i class="fa-solid fa-user-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Present</span>

                <?php 
                  $sql = "SELECT COUNT(*) AS present FROM attendance WHERE status='Present' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $present = $row['present'];
                  
                  ?>
                <span class="info-box-number">
               <?php echo  $present; ?>
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
            <a href="#" style="color:black">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1">  <i class="fa-solid fa-user-xmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Absent</span>

                <?php
                 
                  
                 $sql = "SELECT COUNT(*) AS Absent FROM attendance WHERE status='Absent'";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $absent = $row['Absent'];
                  
                  ?>
                <span class="info-box-number">
               <?php echo  $absent ?>
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
        <a href="#" style="color:black">
        <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1">  <i class="fa-solid fa-user-minus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Late</span>
                <?php
                 
                  
                  $sql = "SELECT COUNT(*) AS late FROM attendance WHERE status='Late'";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $late = $row['late'];
                  
                  ?>
                <span class="info-box-number">
               <?php echo  $late ?>
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
                <h5 class="card-title">Yearly Recap Report - <?php echo date('Y') ?></h5>

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
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>This Year</strong>
                    </p>

                    <div class="chart">
                    <?php


                          $year = date('Y');

                          $query = $con->query("SELECT week AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Present' GROUP BY week ");

                          foreach ($query as $row) {


                            $sy[] = $row['ms'];

                            $sam[] = $row['sam'];




                          }
                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT week AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Absent' GROUP BY week  ");

                          foreach ($query as $row) {




                            $sam1[] = $row['sam'];


                          }

                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT week AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Late' GROUP BY week");

                          foreach ($query as $row) {




                            $sam2[] = $row['sam'];




                          }
                          ?>
                          <?php


                       
                          ?>
                      <canvas id="dot" style="height: 220px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                  <div class="card">
             
            
             
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

<?php include_once('att_chart.php'); ?>
</body>
</html>
