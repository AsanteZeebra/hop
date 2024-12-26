<?php 
include_once('database_connection.php');



include_once('load_session.php');
 
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

   
       

  <!-- Post -->
  <div class="post">
                      <div class="user-block">
                        
                      <?php

$mem_id = $_GET['img'];


     $sql = "SELECT * FROM photos WHERE member_id = '$mem_id'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
          $image = $row['file_name'];
       
      

     ?>  
                        <img class="img-circle img-bordered-sm" src="uploads/<?php echo $image; ?>" alt="user image">
                        <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>

                        <?php

$report_id = $_GET['rid'];


     $sql = "SELECT * FROM reports WHERE id = '$report_id'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
            $report_id = $row['report_id'];
            $name = $row['fullname'];
            $member_id = $row['member_id'];
            $tittle = $row['tittle'];
            $date_created = $row['date_created'];
            $department = $row['department'];
            $message = $row['message'];
       
      

     ?>  
                        <span class="username">
                          <a href="#"><?php echo $name ?></a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description"><?php echo $department ?> - <?php echo $date_created ?></span>
                        <hr>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <?php echo $message; ?>
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->
          

            <?php    }
                  } else {
                    echo "No Records Found";
                  } 
                  
                  ?>
      
   
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
