<?php 
 include_once('database_connection.php');

include_once('load_session.php');

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Departments</title>
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
            <h1>Departments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Departments</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
   

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" style="justify-content: center; margin-top:60px;" >
    <div class="col-md-3 col-sm-6 col-12" >
           <a href="ad_dashboard.php?mid=<?php echo $_GET['mid']; ?> && dept=Men " target='blank'>
           <div class="info-box" style="background-color:#233F93">
              <span class="info-box-icon"><i class="fa-solid fa-person-circle-plus" style="color: #ffffff;"></i></span>
              <div class="info-box-content">
                 <span class="info-box-text" style="color:white">Men's Department</span>
                <span class="info-box-number" style="color:white"></span>
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <a href="ad_dashboard.php?mid=<?php echo $_GET['mid'] ?> && dept=Women" target='blank'>
            <div class="info-box " style="background-color: #C8A43E">
              <span class="info-box-icon"><i class="fa-solid fa-list-check" style="color:white"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:white">Women's Department</span>
                <span class="info-box-number" style="color:white"></span>
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
           <a href="ad_dashboard.php?mid=<?php echo $_GET['mid'] ?> && dept=Youth" target='blank'>
           <div class="info-box bg-gradient-info">
              <span class="info-box-icon"><i class="fa-solid fa-address-card"></i></span>

              <div class="info-box-content">
             
                <span class="info-box-text" style="color:white">Youth Dpartment</span>
                <span class="info-box-number" style="color:white"></span>
                

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>

            <div class="col-md-3 col-sm-6 col-12">
           <a href="#">
           <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fa-solid fa-address-card"></i></span>

              <div class="info-box-content">
             
                <span class="info-box-text" style="color:white">Children's Dpartment</span>
                <span class="info-box-number" style="color:white"></span>
                

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
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
<?php include_once('script.php'); ?>




</body>
</html>
