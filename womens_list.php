<?php 
include_once('database_connection.php');


include_once('load_session.php');



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Womes List</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar_women.php'); ?>
  </nav>
  <!-- /.navbar -->
  <?php include_once('womens_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Womens Fellowship</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">womens_fellowship</li>
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
<table class="table table-hover " table id="example1">
<thead>
      <tr style="text-align:center">
      <th>ID</th>
      <th>Name</th>
      <th>Telephone</th>
      <th>Marital_status</th>
      <th>Age</th>
      <th>Occupation</th>
      <th>Status</th>
      
      </tr>
    </thead>

   <tbody>
   <?php
                
                  
                  $sql = "SELECT * from  members WHERE gender='Female' AND age > 28 OR marital_status='married' AND gender='Female' ORDER BY fullname ASC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id'];
                      $member_id = $row['member_id'];
                      $fullname = $row['fullname'];
                      $telephone = $row['telephone'];
                      $residence_address = $row['residense_address'];
                      $status = $row['status'];
                      $age = $row['age'];
                      $marital = $row['marital_status'];
                      $occupation = $row['occupation'];
                      

                  ?>
      <tr style="text-align:center">
        <td><a href="#"><?php echo $member_id; ?></a></td>
        <td><?php echo $fullname; ?></td>
        <td><?php echo $telephone; ?></td>
        <td><?php echo $marital; ?></td>
        <td><?php echo $age; ?></td>
        <td><?php echo $occupation; ?></td>

        <?php if($status == "Active"){
          echo "<td><i class='fa-regular fa-circle-check' style='color:#218838' data-toggle='tooltip' data-placement='top' title='Member is Active'></i> Active</td>
          ";
        }else{
          echo "<td><i class='fa-solid fa-user-xmark' style='color:#B30B00' data-toggle='tooltip' data-placement='top' title='Member is Inactive'> Inactive</i></td>
          ";
        }
        
        ?>
       
       
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


</body>
</html>
