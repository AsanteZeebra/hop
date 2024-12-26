<?php 
include_once('load_session.php');
include_once('database_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Candidate | Preview</title>
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
            <h1>Member info</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">member_info</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php
              
              $pass = $_GET['uid'];

                $sql = "SELECT * from  members WHERE member_id='$pass'";
                $result = mysqli_query($con, $sql);
                if ($result) {
                  while ($row = mysqli_fetch_array($result)) {

                   

                    ?>
      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card">
    <div class="card-body">
 <center>
   <img src="dist/img/hop1.png" alt="" style="width: 150px; height: 150px;">
 </center>
<hr>
    <br>
  
    <table class="table table-borderless">
    <thead>
        <tr>
            <th>Member #ID</th>
            <th>Date Added</th>
            <th>House Address</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['date_created']; ?></td>
            <td><?php echo $row['residense_address']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    </tbody>
</table>
<br>

<div class="row">
<div class="col-sm-2"><b><h4>Personal Info </h4></b> </div> <div class="col-sm-10"><hr style="background-color: #505050;"></div>
</div>
<div class="row">
    <div class="col-sm-10">
        <table class="table ">
            <tr>
                <td>Fullname</td>
                <td>Region</td>
                <td>Marital Status</td>
                <td>Age</td>
            </tr>
            <tr>
                <td><b><?php echo $row['fullname']; ?></b></td>
                <td><b><?php echo $row['region']; ?></b></td>
                <td><b><?php echo $row['marital_status']; ?></b></td>
                <td><b><?php echo $row['age']; ?> Years</b></td>
            </tr>
            <tr>
                <td>Date of birth</td>
                <td>Occupation</td>
                <td>House Address</td>
                <td>Telephone</td>
            </tr>
            <tr>
                <td><b><?php echo $row['dob']; ?></b></td>
                <td><b><?php echo $row['occupation']; ?></b></td>
                <td><b><?php echo $row['residense_address']; ?></b></td>
                <td><b><?php echo $row['telephone']; ?></b></td>
            </tr>
            <tr>
                <td>Date of 'Alter Call'</td>
                <td>gender</td>
                <td>Position</td>
                <td>City/Town</td>
            </tr>
            <tr>
                <td><b><?php echo $row['alter_call']; ?></b></td>
                <td><b><?php echo $row['gender']; ?></b></td>
                <td><b><?php echo $row['position']; ?></b></td>
                <td><b><?php echo $row['city']; ?></b></td>
            </tr>
            <tr>
                <td>Spouse Name</td>
                <td>Number of Children</td>
                <td>Next of kin</td>
                <td></td>
            </tr>
            <tr>
                <td><b><?php echo $row['spouse']; ?></b></td>
                <td><b><?php echo $row['number_of_children']; ?></b></td>
                <td><b><?php echo $row['next_of_kin']; ?></b></td>
                <td><b></b></td>
            </tr>
        
        </table>
    </div>

    <div class="col-sm-2">
        <img src="uploads/<?php echo $row['file_name'] ?>" alt="" style="with: 150px; height: 150px;">
    </div>
</div>

      </div>
  </div>
</div>
  </div>
  <?php }
                  } else {
                    echo "No Record Found!";
                  } ?>
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
  window.addEventListener("load", window.print());
</script>

</body>
</html>
