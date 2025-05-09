
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members Statistics</title>
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
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php include_once('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $_GET['mn']; ?>'s Statistics</h1>
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

      <!-- Default box -->
    

     <div class='row'>
         <div class='col-6'>
            
  <div class="card">
    <div class="card-body">

<div class="chart">
  <?php
 include_once('database_connection.php');
 
 $idd = $_GET['idd'];

     $query = $con->query("SELECT COUNT(*) AS mb, status AS st FROM attendance WHERE member_id='$idd'  GROUP BY status ");

                foreach ($query as $row) {


                  $sy[] = $row['st'];

                  $sam[] = $row['mb'];
  
                }
                ?>


                  <canvas id="dot" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>

      </div>
  </div> 
         </div>
         
          <div class='col-6'>
            
  <div class="card">
    <div class="card-body">
     <h5>Last Five(5) weeks</h5>
       <table class="table">
         <tr>
             <thead>
                 <th>ID</th>
                  <th>Month</th>
                   <th>Year</th>
                    <th>Week</th>
                    <th>Status</th>
             </thead>
         </tr>
         <tbody>
                <?php
                  $ii = $_GET['idd'];
                  
                  $sql = "SELECT*FROM attendance WHERE member_id='$ii' ORDER BY id DESC LIMIT 5 ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $id = $row['id'];
                       $month = $row['month'];
                       $year = $row['year'];
                       $week = $row['week'];
                       $status = $row['status'];
                    
                  ?>
             <tr>
               <td><?php echo $id ?></td>
               <td><?php echo $month ?></td>
               <td><?php echo $year ?></td>
               <td><?php echo $week ?></td>
               <?php if($status === 'Present'){
               echo ' <td><i class="fa fa-circle-check" style="color:green"></i></td>';
               }else{
                   echo ' <td><i class="fa fa-times" style="color:red"></i></td>';
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
       </table>



      </div>
  </div> 
         </div>
         
        
         <div class='col-6'>
            
  <div class="card">
    <div class="card-body">

<div class="chart">
  <?php
 include_once('database_connection.php');
 
 $idd = $_GET['idd'];

     $query = $con->query("SELECT COUNT(*) AS mb,status FROM dues WHERE member_id='$idd' AND status='Paid'");
      

                foreach ($query as $row) {


                  $ym[] = $row['status'];
                  $am[] = $row['mb'];
                  
                 
                  
                
  
                }
                
                
                ?>


                  <canvas id="bar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>

      </div>
  </div> 
         </div>
         
          <div class='col-6'>
            
  <div class="card">
    <div class="card-body">
     <h5>Last Five(5) Monts - Warefare </h5>
       <table class="table">
         <tr>
             <thead>
                 <th>ID</th>
                  <th>Month</th>
                   <th>Year</th>
                    <th>Amount</th>
                    <th>Status</th>
             </thead>
         </tr>
         <tbody>
                <?php
                  $ii = $_GET['idd'];
                  
                  $sql = "SELECT*FROM dues WHERE member_id='$ii' ORDER BY id DESC LIMIT 5 ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $id = $row['id'];
                       $month = $row['month'];
                       $year = $row['year'];
                    $amount = $row['amount'];
                       $status = $row['status'];
                    
                  ?>
             <tr>
               <td><?php echo $id ?></td>
               <td><?php echo $month ?></td>
               <td><?php echo $year ?></td>
               <td><?php echo number_format($amount,2) ?></td>
               <?php if($status === 'Present'){
               echo ' <td><i class="fa fa-circle-check" style="color:green"></i></td>';
               }else{
                   echo ' <td><i class="fa fa-times" style="color:red"></i></td>';
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
<?php include_once("profile_chart.php"); ?>



</body>
</html>
