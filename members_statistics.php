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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
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
            <h1>Members Statistics</h1>
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

     $query = $con->query("SELECT COUNT(fullname) AS mb, gender AS gen FROM members GROUP BY gen");

                foreach ($query as $row) {


                  $sy[] = $row['gen'];

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

       <table class="table">
           <tr>
                <?php
                  $sql = "SELECT COUNT(*) as total FROM members WHERE gender='Male' AND age > 28 OR marital_status='married' AND gender='Male'";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
               <td><i class='fa fa-user'></i> Men</td>
               <td><?php echo $total; ?></td>
                  <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
           </tr>
            <tr>
                  <?php
                  $sql = "SELECT COUNT(*) as total FROM members WHERE gender='Female' AND age > 28 OR marital_status='married' AND gender='Female'";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
               <td> <i class='fa-solid fa-user-large'></i> Women</td>
               <td><?php echo $total; ?></td>
                  <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
               
           </tr>
             <tr>
                   <?php
                  $sql = "SELECT COUNT(*) AS total from  members WHERE age between 13 AND 28 AND marital_status='single'";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
               <td><i class='fa fa-users'></i> Youth</td>
               <td><?php echo $total; ?></td>
                 <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
               
           </tr>
           
             <tr>
                  <tr>
                  <?php
                  $sql = "SELECT COUNT(*) AS total from  members WHERE age < 13";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
               <td><i class='fa-solid fa-children'></i> Children</td>
               <td><?php echo $total; ?></td>
               <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
           </tr>
             <tr>
                  <tr>
                   <?php
                  $sql = "SELECT COUNT(*) AS total from  members";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
               <td><b>Total:</b></td>
               <td><b><?php echo $total; ?></b></td>
               <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
           </tr>
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
<?php include_once("members_chart.php"); ?>



</body>
</html>
