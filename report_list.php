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
  <title>Reports </title>
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
            <h1>Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">reports</li>
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

    <table class="table" id="example4">
        <thead>
            <tr>
                <th></th>
                <th>#ID</th>
                <th>Sent_By</th>
                <th>Member_ID</th>
                <th>Tittle</th>
                <th>date_created</th>
            </tr>
        </thead>
        <tbody>
        <?php

$mem_id = $_GET['mid'];


     $sql = "SELECT * FROM reports";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
            $id = $row['id'];
            $report_id = $row['report_id'];
            $name = $row['fullname'];
            $member_id = $row['member_id'];
            $tittle = $row['tittle'];
            $date_created = $row['date_created'];
       
      

     ?>  
            <tr>
                <td ><img src="dist/img/rr.JPEG" alt="" style="width:50px; height: 50px;"></td>
                <td><a href="view_report.php?rid=<?php echo $id; ?> &mid=<?php echo $mem_id; ?> &&img=<?php echo $member_id; ?>"><?php echo $report_id ?></a></td>
                <td><?php echo $name ?></td>
                <td><?php echo $member_id ?></td>
                <td><?php echo $tittle ?></td>
                <td><?php echo $date_created ?></td>
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
