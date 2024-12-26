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
    <!-- Navbar -->
    <?php include_once('att_navbar.php'); ?>
    <!-- /.navbar -->
    <?php include_once('att_sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">

          <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i>
            Back</button>
          <br>
          <br>
          <!-- /.col -->
          <div class="col-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <?php

              $mem_id = $_GET['uid'];
              $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
              $run = mysqli_query($con, $sql);
              if ($run) {
                while ($row = mysqli_fetch_assoc($run)) {


                  $member_name = $row['fullname'];
                  $address = $row['residense_address'];
                  $telephone = $row['telephone'];
                  $photo = $row['file_name'];


                  ?>
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-primary">
                    <h3 class="widget-user-username"><?php echo $member_name; ?></h3>
                    <h5 class="widget-user-desc"><?php echo $address; ?></h5>
                  </div>
                  <div class="widget-user-image">

                    <?php if (mysqli_num_rows($run) > 0) {
                      echo "<img class='img-circle elevation-2' src='uploads/$photo' alt='User Avatar'>";
                    } else {
                      echo "<img class='img-circle elevation-2' src='dist/img/user.png' alt='User Avatar'>";
                    }
                    ?>

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
                      $mem_id = $_GET['uid'];
                      $sql = "SELECT COUNT(*) as total FROM attendance WHERE status='Present' and member_id='$mem_id' ";
                      $run = mysqli_query($con, $sql);
                      if ($run) {
                        while ($row = mysqli_fetch_assoc($run)) {

                          $total = $row['total'];
                          ?>
                          <h5 class="description-header"><?php echo $total ?> out of 52/3(weeks)</h5>
                          <span class="description-text">Presents</span>

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
                      $mem_id = $_GET['uid'];
                      $sql = "SELECT COUNT(*) as total FROM attendance WHERE status='Absent' and member_id='$mem_id' ";
                      $run = mysqli_query($con, $sql);
                      if ($run) {
                        while ($row = mysqli_fetch_assoc($run)) {

                          $total = $row['total'];
                          ?>
                          <h5 class="description-header"><?php echo $total; ?> out of 53/3(weeks)</h5>
                          <span class="description-text">Absents</span>
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
              <form method="POST">
                <div class="modal-body">
                  <div class='row'>
                    <div class='col-3'>
                      <input hidden type="text" class='form-control tfd'>
                    </div>
                    <div class='col-3'>
                      <input hidden type="text" class='form-control tfm'>
                    </div>

                    <div class='col-3'>
                      <input hidden type="text" class='form-control tfy'>
                    </div>
                    <div class='col-3'>
                      <input hidden type="text" class='form-control tfw'>
                    </div>

                  </div>
                  <center>
                    <button class="btn btn-info" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger delbtn">Yes</button>
                  </center>

                </div>
              </form>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="atmodal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"> Mark Attendance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">


                <form method="post" id='atform'>

                  <input hidden type="text" name='idd' class='form-control tfid' value='<?php echo $_GET['uid'] ?>'>
                  <input hidden type="text" name='nnm' class='form-control tfname' value='<?php echo $_GET['fname'] ?>'>
                  <div class='row'>

                    <div class='col-4'>
                      <div class='form-group'>
                        <label>Year</label>
                        <select name="year" class='form-control tfyear'>
                          <option value="<?php $w = date('Y');
                          echo $w; ?>"><?php $w = date('Y');
                            echo $w; ?></option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                          <option value="2027">2027</option>
                          <option value="2028">2028</option>
                          <option value="2029">2029</option>
                          <option value="2030">2030</option>
                          <option value="2031">2031</option>
                        </select>
                      </div>
                    </div>

                    <div class='col-4'>
                      <div class='form-group'>
                        <label>Month</label>
                        <select name="month" class='form-control tfmonth'>
                          <option value="<?php $w = date('F');
                          echo $w; ?>"><?php $w = date('F');
                            echo $w; ?></option>
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


                    <div class='col-4'>
                      <div class='form-group'>
                        <label>Week</label>
                        <select name="week" class='form-control tfweek'>
                          <option value="<?php $w = date('W');
                          $fw = "week$w";
                          echo $fw; ?>">
                            <?php $w = date('W');
                            $fw = "week$w";
                            echo $fw; ?> </option>
                          <option value='week1'>week1</option>
                          <option value="week2">week2</option>
                          <option value="week3">week3</option>
                          <option value="week4">week4</option>
                          <option value="week5">week5</option>
                          <option value="week6">week6</option>
                          <option value="week7">week7</option>
                          <option value="week8">week8</option>
                          <option value="week9">week9</option>
                          <option value="week10">week10</option>
                          <option value="week11">week11</option>
                          <option value="week12">week12</option>
                          <option value="week13">week13</option>
                          <option value="week14">week14</option>
                          <option value="week15">week15</option>
                          <option value="week16">week16</option>
                          <option value="week17">week17</option>
                          <option value="week18">week18</option>
                          <option value="week19">week19</option>
                          <option value="week20">week20</option>
                          <option value="week21">week21</option>
                          <option value="week22">week22</option>
                          <option value="week23">week23</option>
                          <option value="week24">week24</option>
                          <option value="week25">week25</option>
                          <option value="week26">week26</option>
                          <option value="week27">week27</option>
                          <option value="week28">week28</option>
                          <option value="week29">week29</option>
                          <option value="week30">week30</option>
                          <option value="week31">week31</option>
                          <option value="week32">week32</option>
                          <option value="week33">week33</option>
                          <option value="week34">week34</option>
                          <option value="week35">week35</option>
                          <option value="week36">week36</option>
                          <option value="week37">week37</option>
                          <option value="week38">week38</option>
                          <option value="week39">week39</option>
                          <option value="week40">week40</option>
                          <option value="week41">week41</option>
                          <option value="week42">week42</option>
                          <option value="week43">week43</option>
                          <option value="week44">week44</option>
                          <option value="week45">week45</option>
                          <option value="week46">week46</option>
                          <option value="week47">week47</option>
                          <option value="week48">week48</option>
                          <option value="week49">week49</option>
                          <option value="week50">week50</option>
                          <option value="week51">week51</option>
                          <option value="week52">week52</option>


                        </select>
                      </div>
                    </div>


                    <div class='col-12'>
                      <div class='form-group'>
                        <label>Status</label>
                        <select name="status" class='form-control sttt'>
                          <option value="">--Choose status--</option>
                          <option value="Present">Present</option>
                          <option value="Absent">Absent</option>
                          <option value="Late">Late</option>

                        </select>
                      </div>
                    </div>


                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btconfirm">Confirm</button>
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
            <div class="card">
              <div class="card-body">
                <div style='float:right;'><a href="#" data-toggle='modal' data-target='#atmodal'
                    class='btn btn-primary btn-sm'><i class='fa fa-plus'></i> Mark Attendance</a></div>

                <br>
                <br>
                <table class="table table-hover " table id="example1">
                  <thead>
                    <tr style="text-align:center">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Year</th>
                      <th>Month</th>
                      <th>Week</th>
                      <th>Date_created</th>
                      <th>Status</th>
                      <th></th>

                    </tr>
                  </thead>

                  <tbody>


                    <?php

                    $mem_id = $_GET['uid'];
                    $sql = "SELECT * FROM attendance WHERE member_id='$mem_id' ";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {


                        $member_id = $row['member_id'];
                        $name = $row['fullname'];
                        $year = $row['year'];
                        $month = $row['month'];
                        $week = $row['week'];
                        $status = $row['status'];
                        $date_created = $row['date_created'];

                        ?>

                        <tr style='text-align:center;'>
                          <td><?php echo $member_id ?></td>
                          <td><?php echo $name ?></td>
                          <td><?php echo $year ?></td>
                          <td><?php echo $month ?></td>
                          <td><?php echo $week ?></td>
                          <td><?php echo $date_created; ?></td>
                          <?php
                          if ($status === "Present") {
                            echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> $status </td>";
                          } elseif ($status === "Late") {
                            echo "<td><i class='fa-regular fa-circle-check' style='color:#FCC423'></i> $status </td>";

                          } elseif($status === "Absent") {
                            echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> $status</td>";
                          }elseif(empty($status)) {
                            echo "<td> <i class='fa-regular fa-circle-xmark' style='color:gray'></i> $status</td>";
                          }
                          ?>
                          <td><a href="#" data-toggle="modal" data-target="#mdquestion" class='ll'><i class='fa fa-trash'
                                style="color:red"></i></a></td>
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

  <?php include_once("attendance.php"); ?>
  <script>

    $('.back').click(function () {
      if (document.referrer) {
        window.location.href = document.referrer;
      } else {
        window.history.back();
      }

    });

  </script>

</body>

</html>