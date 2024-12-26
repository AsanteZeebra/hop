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
  <title> HOP | Members List </title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('att_navbar.php'); ?>
  <!-- /.navbar -->
  <?php include_once('att_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Members</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Card View</a></li>
              <li class="breadcrumb-item active">Members</li>
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
        
 
 
<table class="table table-hover "  id="example1">
    <thead>
      <tr style="text-align:center">
        <th><i class="fa fa-image"></i></th>
      <th>ID</th>
      <th>Name</th>
      <th>Telephone</th>
      <th>Marital_status</th>
      <th>Address</th>
      <th>Status</th>
      <th><i class="fa-solid fa-bars"></i></th>
      </tr>
    </thead>

   <tbody>
   <?php
                 
                  
                  $sql = "SELECT * from  members ORDER BY member_id DESC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id'];
                      $member_id = $row['member_id'];
                      $fullname = $row['fullname'];
                      $telephone = $row['telephone'];
                      $residence_address = $row['residense_address'];
                      $status = $row['status'];
                      $photo = $row['file_name'];
                      $age = $row['age'];
                      $marital = $row['marital_status'];
                      $children = $row['number_of_children'];
           
                  ?>
      <tr style="text-align:center">
      <?php 
if (!empty($photo)) {
    echo "<td><img src='uploads/$photo' alt='img' style='width:50px; height: 50px;'></td>"; 
} else {
    echo "<td><img src='dist/img/user.png' alt='img' style='width:50px; height: 50px;'></td>";
}
?>

        
        <td><a href="#"><?php echo $member_id; ?></a></td>
        <td><?php echo $fullname; ?> <br> <small><?php echo $age  ?> Years</small></td>
        <td><?php echo $telephone; ?></td>
        <td><?php echo $marital; ?> <br> <small><?php echo $children ?> child/ren</small></td>
        <td><?php echo $residence_address; ?></td>
      
        <?php if($status == "Active"){
          echo "<td><label class='badge badge-success' data-toggle='tooltip' data-placement='top' title='Member is Active'>$status</label> </td>
          ";

        }elseif($status == "Pending") {
          echo "<td><label class='badge badge-warning' data-toggle='tooltip' data-placement='top' title='Pending'>$status</label> </td>
          ";
        }else {
          echo "<td><label class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='Member is Inactive'>Inactive</label> </td>
          ";
        }
        
        
        ?>
       
       
        <td><a href="att_records.php?mid=<?php echo $_GET['mid'] ?>&uid=<?php echo htmlspecialchars($row['member_id']);  ?>&&fname=<?php echo htmlspecialchars($row['fullname']); ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-chart-line"></i></a></td>
     
    
    
    </tr>
    
      <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
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

<script>
  
  $('.back').click(function(){
    if (document.referrer) {
      window.location.href = document.referrer;
  } else {
      window.history.back();
  }

  });

</script>

</body>
</html>
