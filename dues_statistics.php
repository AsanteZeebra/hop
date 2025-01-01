<?php include_once('database_connection.php'); 


include_once('load_session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dues | Statistics </title>
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
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <?php

$mem_id = $_GET['idd'];
$department =  $_GET['dept'];

echo $department;

     $sql = "SELECT COUNT(*) as mt FROM dues WHERE member_id='$mem_id' AND status='Paid' AND department='$department'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
        $amount = $row['mt'];
       
      

     ?>
        <li><b>Paid: <?php echo $amount  ?> Month/s</b> </li>
<?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
      
       <?php

$mem_id = $_GET['idd'];

$department = $_GET['dept'];


     $sql = "SELECT COUNT(*) as mt FROM dues WHERE member_id='$mem_id' AND status='Unpaid' AND department='$department'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
        $amount = $row['mt'];
       
      

     ?>
        <li style='color:red;padding-left:50px; padding-right:30px'><b>Unpaid(¢): <?php echo $amount ?> Month/s</b> </li>
<?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
  
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php
  $department = $_GET['dept'];

  switch ($department) {
    case 'Main':
      include_once('sidebar.php');
      break;
    case 'Men':
    include_once('mens_sidebar.php');
        break;
    case 'Women':
        include_once('womens_sidebar.php');
        break;
        case 'Youth':
        include_once('youth_sidebar.php');
            break;
    default:
        echo "No department specified";
        break;
  }
  
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Overall Statistics</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Members</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline-primary">
          
          <div class="card-body">
            <div class="row">
              <div class="col-12">
               
                    <?php
                    $mem_id = $_GET['idd'];
                    $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) as total,fullname,member_id FROM dues WHERE member_id='$mem_id' AND department='$department'";

                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {
                        $total = $row['total'];
                        $name = $row['fullname'];
                        $member_id = $row['member_id'];
                     
                    ?>
                 <div >
                 <h6><?php echo $name ?> - <?php echo $member_id ?></h6>
                   
                   
                 </div>
                
                </div>
                    </div>
                    </div>

                    <?php 
                     }
                    } else {
                      echo "No records found";
                    }
                    ?>


    </div>

      <!-- Default box -->
    <div class="row" >

 <div class="col-6">
   <!-- BAR CHART -->
   <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Paid Warefare Statistics <i class='fa fa-line-chart'></i></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="">
  <?php


       $mem_id =$_GET['idd'];
       $department = $_GET['dept'];

                $query = $con->query("SELECT year AS ys, COUNT(amount) sam FROM dues  WHERE status='Paid' AND member_id='$mem_id' AND department='$department' GROUP BY ys ");

                foreach ($query as $row) {


                  $sy[] = $row['ys'];

                  $sam[] = $row['sam'];

                  

                 
                }
                ?>


                  <canvas id="bar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</div>



<div class="col-6">
   <!-- BAR CHART -->
   <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Payment Statistics <i class='fa fa-pie-chart'></i></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="">
  <?php

                 $mem_id =$_GET['idd'];
                 $department = $_GET['dept'];
                $query = $con->query("SELECT COUNT(amount) AS ct, status AS st FROM dues WHERE member_id='$mem_id' AND department='$department' GROUP BY st");

                foreach ($query as $row) {


                  $s[] = $row['st'];

                  $c[] = $row['ct'];

                  

                 
                }
                ?> 
 <canvas id="dot" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</div>


  </div>

  
  <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report </h5>

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
                  <div class="col-md-6">
                   
<p class=text-center>
  <b>This Year <?php echo date('Y') ?></b>
</p>
                    <table class='table table-hover'>
                      <thead style='background-color:#28A745;color:white'>
                        <tr>
                          <th>ID</th>
                          <th>Month</th>
                          <th>Amount</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php

$mem_id = $_GET['idd'];
$year = date('Y');
$department = $_GET['dept'];

     $sql = "SELECT * FROM dues WHERE member_id='$mem_id' AND year='$year' AND department='$department'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
         $id = $row['id'];
        $month = $row['month'];
        $amount = $row['amount'];
        $status = $row['status'];
        $year = $row['year'];

      

     ?>
                        <tr>
                          <td><?php echo $id ?></td>
                          <td><?php echo $year ?> <?php echo $month ?></td>
                          <td><?php echo $amount?></td>
                          <?php 
                  if($status === "Paid"){
                    echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> Paid </td>";
                 
                  }else{
                    echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> Unpaid </td>";
                  }
                  
                  ?>
                          
                        <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
                      </tbody>
                      <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                    </table>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <p class="text-center">
                      <strong>Last Year <?php echo date('Y')-1 ?></strong>
                    </p>

                   
                  <table class='table table-hover'>
                    <thead style='background-color:#B30B00;color:white'>
                      <tr>
                        <th>ID</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

$mem_id = $_GET['idd'];
$year = date('Y');
$department = $_GET['dept'];
$lastyear = $year-1;
     $sql = "SELECT * FROM dues WHERE member_id='$mem_id' AND year='$lastyear' AND department='$department'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
         $id = $row['id'];
        $month = $row['month'];
        $amount = $row['amount'];
        $status = $row['status'];

      

     ?>
                      <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $month ?></td>
                        <td><?php echo number_format($amount,2) ?></td>
                        <?php 
                  if($status === "Paid"){
                    echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> Paid </td>";
                 
                  }else{
                    echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> Unpaid </td>";
                  }
                  
                  ?>
                      </tr>
                      <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
                      </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                  
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->


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
<?php include_once('chart.php') ?>


</body>
</html>
