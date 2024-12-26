<?php

include_once ('database_connection.php');
include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Womens's Monthly Warefare </title>
  <?php include_once ('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include_once('navbar_women.php'); ?>
    </nav>
    <!-- /.navbar -->
    <?php include_once ('womens_sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Womens's Monthly Warefare(¢)</h1>
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
          <div class="col-6">
            <div class="card card-primary card-outline">
              <h3 class="card-title"></h3>
              <div class="card-body">
                <h4 class="badge badge-primary">Top Contributers</h4>
                <table class="table table-hover" id="example2">
                  <thead>
                    <tr>
                      <th>ID#</th>
                      <th>Name</th>
                      <th>Months</th>
                      <th>Amount</th>

                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php


                    $sql = "SELECT COUNT(month) AS mnts,SUM(amount) AS amt,fullname,member_id,status FROM dues WHERE status ='Paid' AND department='Women' GROUP BY fullname ";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {

                        $month = $row['mnts'];
                        $member_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $amount = $row['amt'];
                        $status = $row['status'];


                        ?>
                        <tr>
                          <td><?php echo $member_id; ?></td>
                          <td><?php echo $fullname; ?></td>
                          <td><label for="" class="badge badge-warning"><?php echo $month ?>month/s</label></td>
                          <td><label for=""><?php echo number_format($amount, 2) ?>month/s</label></td>
                          <?php
                          if ($status === "Paid") {
                            echo "<td><span class='badge badge-success'>Paid</span></td>";
                          } else {
                            echo "<td><span class='badge badge-danger'>UnPaid</span></td>";
                          }
                          ?>

                        </tr>
                      <?php }
                    } else {
                      echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                    } ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>

          <div class="col-6">
            <div class="card card-danger card-outline">
              <div class="card-body">
                <h4 class="badge badge-danger">Top Debtors</h4>
                <table class="table table-hover" id="example4">
                  <thead>
                    <tr>
                      <th>ID#</th>
                      <th>Name</th>
                      <th>Months</th>
                      <th>Amount</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT COUNT(month) AS mnts,SUM(amount) AS amt,fullname,member_id,status,year FROM dues WHERE status ='Unpaid' AND department='Women' GROUP BY fullname  ";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {


                        $member_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $year = $row['year'];
                        $month = $row['mnts'];
                        $amount = $row['amt'];
                        $status = $row['status'];
                        ?>
                        <tr>
                          <td><?php echo $member_id; ?></td>
                          <td><?php echo $fullname; ?></td>
                          <td><label for="" class="badge badge-danger"><?php echo $month ?>month/s</label></td>
                          <td><label for=""><?php echo number_format($amount, 2) ?></label></td>
                          <?php
                          if ($status === "Paid") {
                            echo "<td><span class='badge badge-success'>$status</span></td>";
                          } else {
                            echo "<td><span class='badge badge-danger'>$status</span></td>";
                          }
                          ?>

                        </tr>
                      <?php }
                    } else {
                      echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                    } ?>
                  </tbody>
                </table>
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
                    <th>Telephone</th>
                    <th>Occupation</th>
                    <th>Status</th>

                  </tr>
                </thead>

                <tbody style='text-align:center'>
                  <?php


                  $sql = "SELECT * from  members WHERE gender='Female' AND age > 28 OR marital_status='married' AND gender='Female' ORDER BY fullname ASC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id'];
                      $member_id = $row['member_id'];
                      $fullname = $row['fullname'];
                      $telephone = $row['telephone'];
                      $occupation = $row['occupation'];
                      $status = $row['status'];


                      ?>
                      <tr>
                        <td><a
                            href="womens_dues_records.php?idd=<?php echo $member_id ?>&memb=<?php echo $fullname ?> &&mid=<?php echo $_GET['mid'] ?>"><?php echo $member_id; ?></a>
                        </td>
                        <td><?php echo $fullname; ?></td>
                        <td><?php echo $telephone; ?></td>
                        <td><?php echo $occupation; ?></td>
                        <?php if ($status === 'Active') {
                          echo '<td> <i class="far fa-circle" style="color:green"></i> </td>';
                        } else {
                          echo '<td> <i class="far fa-circle" style="color:red"></i> </td>';
                        }

                        ?>

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



  <?php include_once ("script.php"); ?>
  <script src="womens_dues.js"></script>

</body>

</html>