<?php




include_once('load_session.php');

include_once ('database_connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome|HOP|Dashboard|</title>

  <?php include_once ("head.php"); ?>
</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed ">
  <div class="wrapper">

   <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/hop1.png" alt="HOP logo" height="60" width="60">
  </div> 

  <?php include_once('navbar.php'); ?>


    <!-- Sidebar -->
    <?php include_once ('sidebar.php'); ?>

    <div>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper ">
        <!-- Content Header (Page header) -->
        <div class="content-header ">
          <div class="container-fluid ">
            <div class="row mb-2">
              <div class="col-sm-6">
                <?php

                $mem_id = $_GET['mid'];


                $sql = "SELECT fullname FROM account WHERE member_id='$mem_id'";
                $run = mysqli_query($con, $sql);
                if ($run) {
                  while ($row = mysqli_fetch_assoc($run)) {



                    $fullname = $row['fullname'];



                    ?>
                    <h1 class="m-0">Welcome <?php echo $fullname ?> </h1>
                  <?php }
                } else {
                  echo "No Records Found";
                } ?>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard </li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Total Members</span>
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM members";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>

                        <span class="info-box-number"><?php echo $count; ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-receipt"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Reports</span>
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM reports";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number"><?php echo $count; ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill "></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Approved Funds(¢)</span>
                    <?php
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE status = 'Approved'";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>

                        <span class="info-box-number">¢<?php echo number_format($count, 2); ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Users</span>
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM account ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number"><?php echo $count; ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Monthly Recap - Welfare <?php echo date('Y'); ?></h5>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>

                      <div class="btn-group">
                      </div>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        <p class="text-center">

                        </p>

                        <div class="chart">

                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Main' GROUP BY month ");

                          foreach ($query as $row) {


                            $sy[] = $row['ms'];

                            $sam[] = $row['sam'];




                          }
                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Men' GROUP BY month ");

                          foreach ($query as $row) {




                            $sam1[] = $row['sam'];


                          }

                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Women' GROUP BY month  ");

                          foreach ($query as $row) {




                            $sam2[] = $row['sam'];




                          }
                          ?>
                          <?php


                          $year = date('Y');

                          $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM dues  WHERE year='$year' AND status='Paid'AND department='Youth' GROUP BY month  ");

                          foreach ($query as $row) {




                            $sam3[] = $row['sam'];




                          }
                          ?>
                          <div class="chart">
                            <canvas id="dot" style="height:250px;"></canvas>
                          </div>
                        </div>
                        <!-- /.chart-responsive -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-4">
                        <p class="text-center">
                        <h5 class="card-title" style="margin-left:100px;">Attendance Recap - <?php echo date('Y'); ?></h5>
                        </p>
                        <?php

                        $year = date('Y');

                        $query = $con->query("SELECT month AS ms,id, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Present' GROUP BY month  ");

                        foreach ($query as $row) {



                          $month[] = $row['ms'];
                          $tot[] = $row['sam'];




                        }
                        ?>

                        <canvas id="line" style="max-height: 250px;"></canvas>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- ./card-body -->
                  <div class="card-footer">
                    <div class="row">
                    
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Expenses history</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th>Request ID</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Department</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM exepenses ORDER BY id DESC LIMIT 7";
                        $execute = mysqli_query($con, $sql);
                        if ($execute) {
                          while ($row = mysqli_fetch_array($execute)) {

                            $transaction_id = $row['transaction_id'];
                            $category = $row['category'];
                            $status = $row['status'];
                            $department = $row['department'];
                            $amount = $row['amount'];

                            ?>
                            <tr>
                              <td><a href="#" class="text-muted"><?php echo $transaction_id; ?></a></td>
                              <td><?php echo $category; ?></td>
                              <?php
                              if ($status === "Approved") {
                                echo "<td><span class='badge badge-success'> $status</span></td>";
                              } elseif ($status === 'Rejected') {
                                echo " <td><span class='badge badge-danger'> $status</span></td>";
                              } elseif ($status === "Pening") {
                                echo " <td><span class='badge badge-warning'> $status</span></td>";
                              }
                              ?>
                              <td>
                                <?php echo $department; ?>
                              </td>
                              <td><b>¢<?php echo number_format($amount, 2) ?></b></td>
                            </tr>
                          <?php }
                        } else {
                          echo "No Records Found";
                        } ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">

                  <a href="manage_expenses.php?mid=<?php $_GET['mid']; ?>"
                    class="btn btn-sm btn-secondary float-right">View All Requests</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
              <!-- Info Boxes Style 2 -->
              <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fa-solid fa-users-rays" style="color:white"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">General Welfare</span>
                  <?php
                  $sql = "SELECT SUM(amount) AS final FROM dues WHERE status = 'Paid' AND department = 'Main' ";
                  $execute = mysqli_query($con, $sql);
                  if ($execute) {
                    while ($row = mysqli_fetch_array($execute)) {

                      $final = $row['final'];

                      ?>
                      <span class="info-box-number">¢<?php echo number_format($final, 2) ?></span>
                    <?php }
                  } else {
                    echo "No Records Found";
                  } ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fa-solid fa-user"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Mens Welfare</span>

                  <?php
                  $sql = "SELECT SUM(amount) AS final FROM dues WHERE status = 'Paid' AND department = 'Men' ";
                  $execute = mysqli_query($con, $sql);
                  if ($execute) {
                    while ($row = mysqli_fetch_array($execute)) {

                      $final = $row['final'];

                      ?>
                      <span class="info-box-number">¢<?php echo number_format($final, 2) ?></span>
                    <?php }
                  } else {
                    echo "No Records Found";
                  } ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fa-regular fa-user"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Womens Welfare</span>
                  <?php
                  $sql = "SELECT SUM(amount) AS final FROM dues WHERE status = 'Paid' AND department = 'Women' ";
                  $execute = mysqli_query($con, $sql);
                  if ($execute) {
                    while ($row = mysqli_fetch_array($execute)) {

                      $final = $row['final'];

                      ?>
                      <span class="info-box-number">¢<?php echo number_format($final, 2) ?></span>
                    <?php }
                  } else {
                    echo "No Records Found";
                  } ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fa-solid fa-users-line"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Youth Welfare</span>
                  <?php
                  $sql = "SELECT SUM(amount) AS final FROM dues WHERE status = 'Paid' AND department = 'Youth' ";
                  $execute = mysqli_query($con, $sql);
                  if ($execute) {
                    while ($row = mysqli_fetch_array($execute)) {

                      $final = $row['final'];

                      ?>
                      <span class="info-box-number">¢<?php echo number_format($final, 2) ?></span>
                    <?php }
                  } else {
                    echo "No Records Found";
                  } ?>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <?php include_once ('footer.php'); ?>
  </div>
  <!-- ./wrapper -->

  <?php include_once ('script.php'); ?>
  <script>
  // Example: Remove preloader after page load
  window.addEventListener("load", function () {
    document.getElementById("preloader").style.display = "none";
  });
</script>

  <?php
  include_once ('dashbaord_chart.php');
  ?>
</body>

</html>