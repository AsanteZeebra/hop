<?php
include_once('database_connection.php');




 include_once('load_session.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Attendance Records</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once('navbar.php'); ?>
  <?php include_once('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attendance</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <button class="btn btn-primary btn-sm back" style="margin-left:10px;"> <i class="fa fa-arrow-left"></i> Back</button>
    <br>
    <br>

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
              <p>By clicking on confirm will mark attendance of the member as <b>Present</b> and changes can only be made in the members profile page</p>
            <form method="post" id="attendance">
                
            <div class="row">
              <div class="col-12">
             <div class="form-group" hidden>
              <label for="">Name:</label>
                <input type="text" class="form-control tfname">
            </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12" hidden>
                <div class="form-group">
                <label for="">ID:</label>
                 <input type="text" class="form-control tfid">
                
                 
                </div>
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

      
    <div class="modal fade" id="atmodal1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Are you sure?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>By clicking on confirm will mark attendance of the member as <b>Abscent</b> and changes can only be made in the members profile page</p>
            <form method="post" id="attendance">
                
            <div class="row">
              <div class="col-12" hidden>
             <div class="form-group" >
              <label for="">Name:</label>
                <input type="text" class="form-control tfname1">
            </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12" hidden>
                <div class="form-group">
                <label for="">ID:</label>
                 <input type="text" class="form-control tfid1">
                
                 
                </div>
              </div>
            </div>
           
            </div>
            <div>
            
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btconfirm1">Confirm</button>
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
      
      <th style="text-align:right;">ID</th>
      <th style="text-align:right;">Name</th>
      <th style="text-align:right;">Year</th>
      <th style="text-align:right;">Month</th>
      <th style="text-align:right;">Week</th>
      <th style="text-align:right;">Status</th>
      <th><i class="fa fa-bars"></i></th>
     
    
      </tr>
    </thead>

   <tbody>
   <?php

$month = Date('M');
$Week = Date('W');
$Year = Date('Y');

                  $sql = "SELECT*FROM attendance WHERE status='Absent'"; 
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                     
                    $member_id = $row['member_id'];
                    $name = $row['fullname'];
                    $year = $row['year'];
                    $month = $row['month'];
                    $week = $row['week'];
                    $status = $row['status'];

                  ?>
               
             
      <tr style="text-align:center">

        <td style="text-align:right;"><a href="attendance_records.php? mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>&&fname=<?php  echo $name?>"> <?php echo $member_id; ?></a></td>
      
        <td style="text-align:right;"><?php echo $name; ?></td>
        <td style="text-align:right;"><?php echo $year; ?></td>
        <td style="text-align:right;"><?php echo $month; ?></td>
        <td style="text-align:right;"><?php echo $week; ?></td>

        <?php if ($status === "Absent") {
                            echo "<td> <span class='badge badge-danger'>$status</span> </td>";
                          } else {
                            echo "<td> <span class='badge badge-warning'>$status</span></td>";
                          }

                          ?>
        <td><a href="attendance_records.php? mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>&&fname=<?php  echo $name?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i></a></td>
        
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

<script src="attendance.js"></script>

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
