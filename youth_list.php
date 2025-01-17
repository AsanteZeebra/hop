<?php 


include_once('load_session.php');


include_once('database_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Youth List </title>
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
        <a href="youth_dashboard" class="nav-link">Home</a>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
     
    
     
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php include_once('youth_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
<?php 
    
    $sql = "SELECT COUNT(*) AS numbers FROM  members WHERE age between 13 AND 28 AND marital_status='single' ORDER BY fullname ASC";
    $result = mysqli_query($con, $sql);
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
      
        $total = $row['numbers'];
      

?>
            <h1>Youth list(<?php echo $total; ?>)</h1>

            <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">youth_list</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">





    
    <div class="modal fade" id="atmodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Are you sure?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
             

              <form method="post" >
                
            <div class="row">
              <div class="col-6" hidden>
             <div class="form-group" >
              <label for="">ID</label>
                <input type="text" class="form-control tfid">
            </div>
              </div>

              <div class="col-6" hidden>
             <div class="form-group" >
              <label for="">Name:</label>
                <input type="text" class="form-control tfname">
            </div>
              </div>


            </div>

            <div class="row">
              <div class="col-4" hidden>
                <div class="form-group">
                <label for="">Tel:</label>
                 <input type="text" class="form-control tftel">
                </div>
              </div>

              <div class="col-4" hidden>
                <div class="form-group">
                <label for="">Address:</label>
                 <input type="text" class="form-control tfaddress">
                </div>
              </div>
              
            </div>
            
            <div class="col-12">
                <div class="form-group">
                <label for="">Amount:</label>
                 <b><input type="text" class="form-control tfamount" style="text-align:center" placeholder="10.00"></b>
                </div>
              </div>


            </div>
            <div>
            
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btconfirm">Confirm</button>
            </div>

            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div> 
      <!-- /.modal -->
      
      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card">
    <div class="card-body">

    <table class="table table-hover" id="example1">
        <thead>
            <tr style="text-align:center">
                <th>ID</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Occupation</th>
                <th>Age</th>
                <th>Status</th>
              
            </tr>
</thead>

            <tbody style='text-align:center'>
            <?php
                 
                  
                  $sql = "SELECT * from  members WHERE age between 13 AND 28 AND marital_status='single' ORDER BY fullname ASC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id'];
                      $member_id = $row['member_id'];
                      $fullname = $row['fullname'];
                      $telephone = $row['telephone'];
                      $occupation = $row['occupation'];
                      $age = $row['age'];
                      $status = $row['status'];

                      
           
                  ?>

                <tr>
                    <td><a href="#"><?php echo $member_id; ?></a></td>
                    <td><?php echo $fullname; ?></td>
                    <td><?php echo $telephone; ?></td>
                    <td><?php echo $occupation; ?></td>
                    <td><?php echo $age; ?></td>
                     <?php if($status === 'Active'){
                      echo '<td> <i class="far fa-circle" style="color:green"></i> </td>';
                  }else{
                       echo '<td> <i class="far fa-circle" style="color:red"></i> </td>';
                  }
                  
                  ?>

                  </tr>
                <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
            </tbody>
        </thead>
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
