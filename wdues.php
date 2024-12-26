<?php

include_once ('database_connection.php');

include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members|Dues </title>
  <?php include_once ('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
   <?php include_once('navbar.php') ?>
    <!-- /.navbar -->
    <?php include_once ('warefare_sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Monthly_warefare</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <button class="btn btn-primary btn-sm back" style="margin-left:10px;"> <i class="fa fa-arrow-left"></i> Back</button>
      <a href="report_today_general.php?mid=<?php echo $_GET['mid'] ?>" class="btn btn-primary btn-sm " style="margin-left:80%;"> <i class="fa fa-print"></i> Welfare today</a>
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
                <form method="post">

                  <div class="row">
                    <div class="col-6" hidden>
                      <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" class="form-control tfid">
                      </div>
                    </div>

                    <div class="col-6" hidden>
                      <div class="form-group">
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
                      <b><input type="text" class="form-control tfamount" style="text-align:center"
                          placeholder="10.00"></b>
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
        <div class="row">
       <div class="col-12">
        <div class="card card-success">
         <div class="card-header">
         Warefare Statistics - <?php echo date('Y'); ?>
         </div>
        <div class="card-body">
        <div class="chart">
  <?php


     
$year = date('Y');
$query = $con->query("SELECT COUNT(amount) AS ct, month AS st FROM  dues WHERE status='Paid' AND year='$year' AND department='Main' GROUP BY month ");

foreach ($query as $row) {


  $stt[] = $row['st'];

  $ctt[] = $row['ct'];

 }
                ?>

<?php


     
$year = date('Y');
$query = $con->query("SELECT COUNT(amount) AS ct1, month AS st1 FROM  dues WHERE status='Unpaid' AND year='$year' AND department='Main' GROUP BY month");

foreach ($query as $row) {

  $ct1[] = $row['ct1'];

 }
                ?>


                  <canvas id="bar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
        </div>
        </div>
       </div>

      
      

          <div class="col-12">
            <div class="card">
              <div class="card-body">
           
                <table class="table table-hover" id="example1">
                  <thead>
                    <tr style="text-align:center">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Month</th>
                      <th>Amount(¢)</th>
                      <th>Date_paid</th>
                      <th>Status</th>
                      <th><i class="fa fa-bars"></i></th>

                    </tr>
                  </thead>

                  <tbody style='text-align:center'>
                    <?php
                   


                    $sql = "SELECT * from  dues WHERE department='Main' AND status='Unpaid' GROUP BY member_id  ORDER BY year DESC";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                      while ($row = mysqli_fetch_array($result)) {

                        $member_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $amount = $row['amount'];
                        $month = $row['month'];
                        $status = $row['status'];
                        $year = $row['year'];
                        $date_created = $row['date_created'];


                        ?>
                        <tr>
                          <td><a
                              href="deus_records.php?idd=<?php echo $member_id ?>&memb=<?php echo $fullname ?> &mid=<?php echo $_GET['mid']; ?>"><?php echo $member_id; ?></a>
                          </td>
                          <td><?php echo $fullname; ?></td>
                          <td><?php echo $month, $year; ?></td>
                          <td><?php echo number_format($amount, 2); ?></td>
                          <td><?php echo $date_created; ?></td>
                          <?php if ($status === 'Paid') {
                            echo '<td> <span class="badge badge-success">Paid</span> </td>';
                          } else {
                            echo '<td> <span class="badge badge-danger">Unpaid</span></td>';
                          }

                          ?>

                          <td><a href="deus_records.php?idd=<?php echo $member_id ?>&memb=<?php echo $fullname ?> &mid=<?php echo $_GET['mid']; ?>" class="btn btn-primary btn-sm"> <i class="fa fa-arrow-circle-right"></i></a></td>
                        </tr>
                      <?php }
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

    <?php include_once ('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->



  <?php include_once ("script.php");?>
  <script src="dues.js"></script>
  <?php include_once('wchart.php'); ?>

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