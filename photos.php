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
  <title>Photos</title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar.php') ?>
  <!-- /.navbar -->
  <?php include_once('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Photos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Photos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title"> Gallery </h4>
              </div>
              <div class="card-body">
                <div>

                  
                  </div>
                </div>
                <div>
                  <div class="filter-container p-0 row">
                  
                  <?php 
                 
                  $sql = "SELECT * FROM members";
                  $execute = mysqli_query($con,$sql);

                  if($execute){
                    while($row = mysqli_fetch_array($execute)){
                        $photo = $row['file_name'];
                        $name = $row['fullname'];
                       
                   

                  ?>
                  <div class="filtr-item col-sm-2" data-category="1" data-sort="white sample">
                      <a href="uploads/<?php echo $photo; ?>" data-toggle="lightbox" data-title="<?php echo $photo; ?>">
                        <img src="uploads/<?php echo $photo; ?>" class="img-fluid mb-2" alt="image" title="<?php echo $photo ?>" style= "width: 300px; height: 200px;" />
                      </a>
                    </div>
                    
                    <?php 
                     }
                    }else{
                      echo "Data not found";
                    }
                    ?>
                    

                  </div>
                </div>

              </div>
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
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