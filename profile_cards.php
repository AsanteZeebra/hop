<?php include_once('database_connection.php'); 


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
  <title>Members | Pofile Cards</title>
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
       <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members WHERE gender='Male' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
        <a href="#" class="nav-link">Male: <?php echo number_format($numb) ?></a>
         <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
           <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members WHERE gender='Female' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
        <a href="#" class="nav-link">Female: <?php echo number_format($numb) ?></a>
         <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
         <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
   <b style="padding-right:20px">Total: <?php echo number_format($numb) ?></b>
     <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
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
            <h1><a href="members_statistics.php" class='btn btn-primary btn-sm'><i class='fa fa-chart-line'></i> Statistics</a></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="members_list.php">List View</a></li>
              <li class="breadcrumb-item active">Members</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card card-solid" id="pagination">
        <div class="card-body pb-0">
          <div class="row">
          <?php
                  
                  $sql = "SELECT * FROM members ORDER BY fullname Asc ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                    
                  ?>
                                      
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                 <?php echo $row['member_id'] ?>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>  <?php echo $row['fullname'] ?> </b></h2>
                      <p class="text-muted text-sm"><b>Occupation: </b>   <?php echo $row['occupation'] ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: <?php echo $row['residense_address'] ?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <?php echo $row['telephone'] ?></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span> Marital Status: <?php echo $row['marital_status'] ?></li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="dist/img/user.png" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a href="statistics.php? idd=<?php echo $row['member_id']; ?> && mn=<?php echo $row['fullname'] ?>" class="btn btn-sm bg-teal">
                      <i class="fas fa-line-chart"></i>
                    </a>
                    <a href="member_profile.php?mid=<?php echo $row['member_id'] ?>" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Profile
                    </a>
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
        </div>
        <!-- /.card-body -->
       
      </div>
      <!-- /.card -->

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
<?php include_once("chart.php"); ?>



</body>
</html>
