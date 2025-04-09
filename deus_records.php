<?php 

include_once('database_connection.php');


include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Individual Dues Records</title>
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
          <?php

          $mem_id = $_GET['idd'];
          $sql = "SELECT COUNT(month) as month,fullname FROM dues WHERE member_id='$mem_id' AND status='Unpaid' AND department='Main' ";
          $run = mysqli_query($con, $sql);
          if ($run) {
            while ($row = mysqli_fetch_assoc($run)) {

              $mname = $row['fullname'];
              $wk = $row['month'];


              ?>


              <?php
              if ($wk === '0') {

              } else {
                echo " <div class='alert alert-danger alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h5><i class='icon fas fa-info'></i> Notice!</h5>
                   $mname has Unpaid dues for the past $wk month/s
                </div>";
              }

            }
          } else {
            echo "No records found";
          }
          ?>

<button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>

     
          <!-- Widget: user widget style 1 -->
          <div class="card card-widget widget-user">
            <!-- /.col -->
            <div class="col-12">

              <?php

              $mem_id = $_GET['idd'];
              $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
              $run = mysqli_query($con, $sql);
              if ($run) {
                while ($row = mysqli_fetch_assoc($run)) {


                  $member_name = $row['fullname'];
                  $address = $row['residense_address'];
                  $telephone = $row['telephone'];


                  ?>
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-primary">
                    <h3 class="widget-user-username"><?php echo $member_name; ?></h3>
                    <h5 class="widget-user-desc"><?php echo $address; ?></h5>
                  </div>
                  <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="dist/img/user.png" alt="User Avatar">
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header"><?php echo $telephone ?></h5>
                          <span class="description-text">TELEPHONE</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <?php
                }
              } else {
                echo "No records found";
              }

              ?>
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <?php
                      $mem_id = $_GET['idd'];
                      $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
                      $run = mysqli_query($con, $sql);
                      if ($run) {
                        while ($row = mysqli_fetch_assoc($run)) {

                          $status = $row['status'];
                          ?>
                          <h5 class="description-header">Member Status</h5>
                          <span class="description-text"><?php echo $status; ?></span>

                          <?php
                        }
                      } else {
                        echo "No records found";
                      }

                      ?>


                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <?php
                      $mem_id = $_GET['idd'];
                      $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
                      $run = mysqli_query($con, $sql);
                      if ($run) {
                        while ($row = mysqli_fetch_assoc($run)) {

                          $position = $row['member_id'];
                          ?>
                          <h5 class="description-header">Member_id</h5>
                          <span class="description-text"><?php echo $position; ?></span>
                          <?php
                        }
                      } else {
                        echo "No records found";
                      }

                      ?>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->

        </div><!-- /.container-fluid -->
      </section>





      <!-- Main content -->
      <section class="content">


        <div class="modal fade" id="atmodal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Dues payment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">


                <form method="post" id='dues_form'>

                  <input hidden type="text" class='form-control tfid' value='<?php echo $_GET['idd'] ?>'>
                  <input hidden type="text" class='form-control tfname' value='<?php echo $_GET['memb'] ?>'>
                  <div class='row'>

                    <div class='col-6'>
                      <div class='form-group'>
                        <label>Year</label>
                        <select name="year" class='form-control tfyear'>
                          <option value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
                          <option value="2015">2015</option>
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>

                        </select>
                      </div>
                    </div>

                    <div class='col-6'>
                      <div class='form-group'>
                        <label>Month</label>
                        <select name="month" class='form-control tfmonth'>
                          <option value="<?php echo date('F') ?>"><?php echo date('F') ?></option>
                          <option value="January">January</option>
                          <option value="February">February</option>
                          <option value="March">March</option>
                          <option value="April">April</option>
                          <option value="May">May</option>
                          <option value="June">June</option>
                          <option value="July">July</option>
                          <option value="August">August</option>
                          <option value="September">September</option>
                          <option value="October">October</option>
                          <option value="November">November</option>
                          <option value="December">December</option>
                        </select>
                      </div>
                    </div>

                    <div class='col-12'>
                      <div class='form-group'>
                        <label>Amount(¢)</label>
                        <input type="text" class='form-control tfamount' name='amount' placeholder='0.00'
                          style='text-align:center'>
                      </div>
                    </div>

                    <hr>

                  </div>


              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="submitBtn" class="btn btn-success btconfirm">
                  Confirm
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinner"></span>
                </button>
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

          <!-- Delete profile modal -->
          <div class="modal fade" id="mdquestion" style="margin-top: 15%;">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" style="width: 100%; text-align: center;">Are you Sure Want to Delete<i
                      class="fa fa-question"></i></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class='row'>
                    <div class='col-4'>
                      <input hidden type="text" class='form-control tfid'>
                    </div>
                    <div class='col-4'>
                      <input hidden type="text" class='form-control tfmonth'>
                    </div>

                    <div class='col-4'>
                      <input hidden type="text" class='form-control tfyear'>
                    </div>
                  </div>
                  <center>
                    <button class="btn btn-info" data-dismiss="modal">No</button>
                    <button class="btn btn-danger delbtn">Yes</button>
                  </center>

                </div>

              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->


          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div>
                  <a href="dues_statistics.php?&idd=<?php echo $_GET['idd'] ?>&&memb=<?php echo $_GET['memb'] ?> &mid=<?php echo $_GET['mid'] ?> &dept<?php echo $_GET['dept']; ?>"
                    class='btn btn-primary btn-sm'> <i class='fa fa-line-chart'></i> Statistics</a>
                  <a href="#" class='btn btn-primary btn-sm' style='float:right;' data-toggle='modal'
                    data-target='#atmodal'> <i class='fa fa-plus'></i> Make Payment</a>
                </div>
                <br>
                <br>
                <table class="table table-hover " table id="example1">
                  <thead>
                    <tr style="text-align:center">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Year</th>
                      <th>Month</th>
                      <th>Amount(¢)</th>
                      <th>Date_paid</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>


                    <?php

                    $mem_id = $_GET['idd'];


                  $department = $_GET['dept'];
                    $sql = "SELECT * FROM dues WHERE member_id='$mem_id' AND department='$department'  ORDER BY year DESC ";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {


                        $member_id = $row['member_id'];
                        $name = $row['fullname'];
                        $year = $row['year'];
                        $month = $row['month'];
                        $amount = $row['amount'];
                        $status = $row['status'];
                        $date_created = $row['date_created'];

                        ?>

                        <tr style='text-align:center;'>
                          <td><?php echo $member_id ?></td>
                          <td><?php echo $name ?></td>
                          <td><?php echo $year ?></td>
                          <td><?php echo $month ?></td>

                          <td>¢<?php echo number_format($amount, 2); ?></td>
                          <td><?php echo $date_created; ?></td>
                          <?php
                          if ($status === "Paid") {
                            echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> Paid </td>";

                          } else {
                            echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> Unpaid </td>";
                          }

                          ?>
                          <td>

                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"></a>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item btdel" data-toggle='modal' data-target='#mdquestion'
                                href="#">Delete</a>
                            </div>
                          </td>

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
  <script src="validate_dues.js"></script>

  <script>
  $(document).ready(function() {
    $('#dues_form').on('submit', function(event) {
      var submitBtn = $('#submitBtn');
      var spinner = $('#spinner');
      submitBtn.prop('disabled', true);
      spinner.removeClass('d-none');
    });

    $('.back').click(function() {
      if (document.referrer) {
        window.location.href = document.referrer;00
      } else {
        window.history.back();
      }
    });
  });
</script>

</body>

</html>