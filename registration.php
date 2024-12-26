<?php
include_once('database_connection.php');

include_once('load_session.php')
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration | HOP </title>
  <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include_once('reg_navbar.php'); ?>
    <!-- /.navbar -->
    <?php include_once('reg_sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Register</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Members</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">


          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-group"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Registered</span>
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

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-tie"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Men's Dept.</span>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM members WHERE department='Men'";
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

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Women's Dept.</span>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM members WHERE department='Women'";
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

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-people-roof"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Youth</span>
                <?php
                $sql = "SELECT COUNT(*) AS total FROM members WHERE department='Youth'";
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


          <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Member Registration</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="member_form">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card card-default">

                        </div>
                        <div class="card-body p-0">
                          <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                              <!-- your steps here -->
                              <div class="step" data-target="#logins-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                  id="logins-part-trigger">
                                  <span class="bs-stepper-circle"><i class="fa-regular fa-user"></i></span>
                                  <span class="bs-stepper-label">Personal information</span>
                                </button>
                              </div>
                              <div class="line"></div>
                              <div class="step" data-target="#information-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                                  id="information-part-trigger">
                                  <span class="bs-stepper-circle"><i class="fa-solid fa-users"></i></span>
                                  <span class="bs-stepper-label">Family information</span>
                                </button>
                              </div>
                            </div>
                            <div class="bs-stepper-content">
                              <!-- your steps content here -->
                              <div id="logins-part" class="content" role="tabpanel"
                                aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                  <label>FullName</label>
                                  <input type="text" class="form-control tfname" name="fullname"
                                    placeholder="Enter FullName">
                                </div>

                                <div class="row">
                                  <div class="col-4">
                                    <div class="form-group">
                                      <label>Date of Birth:</label>

                                      <input type="date" class="form-control  tfdob" name="dob">

                                    </div>
                                  </div>

                                  <div class="col-4">
                                    <div class="form-group">
                                      <label for="">Age:</label>
                                      <input type="text" class="form-control tfage" name="age" placeholder="Age"
                                        readonly>
                                    </div>
                                  </div>

                                  <div class="col-4">
                                    <div class="form-group">
                                      <label>Date of 'Alter call':</label>
                                      <input type="date" class="form-control tfalter" name="altercall">
                                    </div>
                                  </div>

                                </div>

                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label for="">Gender</label>
                                      <select class="form-control cbgender" name="gender">
                                        <option value="" selected="selected"> --Gender--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                      </select>
                                    </div>
                                  </div>


                                  <div class="col-6">
                                    <div class="form-group">
                                      <label for="">Marital Status</label>
                                      <select class="form-control cbmarital" name="marital">
                                        <option value="" selected="selected"> --Marital Status--</option>
                                        <option value="Single">Single</option>
                                        <option Vaalue="Married">Married</option>
                                        <option valaue="Divorced">Divorced</option>
                                        <option valaue="Widowed">Widowed</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label for="">Occupation</label>
                                      <input type="text" class="form-control tfoccupation" placeholder="Occupation"
                                        name="occupation">
                                    </div>
                                  </div>

                                  <div class="col-6">
                                    <div class="form-group">
                                      <label for="">Telephone</label>
                                      <input type="tel" class="form-control tftel" placeholder="Telephone"
                                        name="telephone">

                                    </div>
                                  </div>


                                </div>

                                <button type="button" class="btn btn-primary nextbtn"
                                  onclick="stepper.next()">Next</button>
                              </div>
                              <div id="information-part" class="content" role="tabpanel"
                                aria-labelledby="information-part-trigger">


                                <div class="form-group">
                                  <label for="exampleInputPassword1">Spouse Name</label>
                                  <input type="text" class="form-control tfspouse" placeholder="Name of Husband / Wife"
                                    name="spouse">
                                </div>

                                <div class="row">
                                  <div class="col-4">
                                    <div class="form-group">
                                      <label for="">No. of Children</label>
                                      <input type="text" class="form-control tfchild" placeholder="Number of children"
                                        name="children">
                                    </div>
                                  </div>

                                  <div class="col-4">
                                    <div class="form-group">
                                      <label for="">City/Town</label>
                                      <input type="text" class="form-control tfcity" placeholder="City/Town"
                                        name="city">
                                    </div>
                                  </div>

                                  <div class="col-4">
                                    <div class="form-group">
                                      <label for="">Region</label>
                                      <input type="text" class="form-control tfregion" placeholder="Region"
                                        name="region">
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-8">
                                    <div class="form-group">
                                      <label for="">Residence Address</label>
                                      <textarea class="form-control tfresidence" cols="30" rows="3"
                                        placeholder="House address" name="houseaddress"></textarea>
                                    </div>
                                  </div>

                                  <div class="col-4">
                                    <div class="form-group">
                                      <label for="">Postal Address</label>
                                      <textarea class="form-control tfpostal" cols="30" rows="3" placeholder="P.O.Box"
                                        name="postbox"></textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-12">
                                  <div class="form-group">
                                    <label for="">Next of kin:</label>
                                    <input type="text" class="form-control tfnextofkin" placeholder="Next of kin"
                                      name="nextofkin">
                                  </div>
                                </div>
                                <button type="button" class="btn btn-primary"
                                  onclick="stepper.previous()">Previous</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-body -->

                      </div>
                      <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->

                </form>
              </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Move to </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="ppp" method='POST'>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="">ID</label>
                        <input disabled type="text" class="form-control tfid" name="memid">
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Name</label>
                        <input disabled type="text" class="form-control tfname" name="fullname">
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Department</label>
                        <select id="" class="form-control tfdepartment" name="department">
                          <option value="">--Choose Department--</option>
                          <option value="Men">Mens Department</option>
                          <option value="Women">Womens Department</option>
                          <option value="Youth">Youth Department</option>
                        </select>
                      </div>
                    </div>

                  </div>

              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal fade" id="float">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Move to <i class="fa fa-arrow-right"></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-hover " id="example1">
                  <thead>
                    <tr style="text-align:center">
                      <th><i class="fa fa-photo"></i></th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Telephone</th>
                      <th>Age</th>
                      <th>Marital_status</th>
                      <th>Occupation</th>
                      <th><i class="fa fa-bars"></i></th>

                    </tr>
                  </thead>

                  <tbody>
                    <?php


                    $sql = "SELECT * from  members";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                      while ($row = mysqli_fetch_array($result)) {
                        $id = $row['id'];
                        $member_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $telephone = $row['telephone'];
                        $residence_address = $row['residense_address'];
                        $status = $row['status'];
                        $marital = $row['marital_status'];
                        $occupation = $row['occupation'];
                        $age = $row['age'];
                        $photo = $row['file_name'];

                        ?>
                        <tr style="text-align:center">
                          <?php
                          if (!empty($photo)) {
                            echo "<td><img src='uploads/$photo' alt='img' style='width:50px; height: 50px;'></td>";
                          } else {
                            echo "<td><img src='dist/img/hop1.png' alt='img' style='width:50px; height: 50px;'></td>";
                          }
                          ?>
                          
                          <td><a href="#"><?php echo $member_id; ?></a></td>
                          <td><?php echo $fullname; ?></td>
                          <td><?php echo $telephone; ?></td>
                          <td><?php echo $age; ?></td>
                          <td><?php echo $marital; ?></td>
                          <td><?php echo $occupation; ?></td>

                          <td><button class="btn btn-primary btn-sm btm" data-toggle="modal" data-target="#default"
                              data-dismiss="modal">Move</button></td>


                        </tr>

                      <?php }
                    } else {
                      echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                    } ?>
                  </tbody>
                </table>
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


              <button class="btn btn-primary btn-sm back"><i class="fa fa-arrow-left"></i> Back</button> <a
                class="btn btn-primary btn-sm" style="float:right" data-toggle="modal" data-target="#modal-lg"
                data-toggle="tooltip" data-placement="top" title="Add New Members"> <i
                  class="fa-solid fa-user-plus"></i> New Member</a>
              <br>
              <br>

              <table class="table table-hover" id="example2">
                <thead>
                  <tr style="text-align:center">
                    <th><i class="fa fa-image"></i></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Telephone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th><i class="fa-solid fa-bars"></i></th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  include_once('database_connection.php');

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

                      ?>
                      <tr style="text-align:center">
                        
                        <?php
                        if (!empty($photo)) {
                          echo "<td><img src='uploads/$photo' alt='img' style='width:50px; height: 50px;'></td>";
                        } else {
                          echo "<td><img src='dist/img/hop1.png' alt='img' style='width:50px; height: 50px;'></td>";
                        }
                        ?>


                        <td><a
                            href="reg_profile.php? mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>"><?php echo $member_id; ?></a>
                        </td>
                        <td><?php echo $fullname; ?> <br> <small><?php echo $age ?> Years</small></td>
                        <td><?php echo $telephone; ?></td>
                        <td><?php echo $residence_address; ?></td>

                        <?php if ($status == "Active") {
                          echo "<td><label class='badge badge-success' data-toggle='tooltip' data-placement='top' title='Member is Active'>$status</label> </td>
          ";

                        } elseif ($status == "Pending") {
                          echo "<td><label class='badge badge-warning' data-toggle='tooltip' data-placement='top' title='Pending'>$status</label> </td>
          ";
                        } else {
                          echo "<td><label class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='Member is Inactive'>Inactive</label> </td>
          ";
                        }


                        ?>


                        <td><a href="reg_edit.php? mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>"
                            class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                            title="Edit Member Information"><i class="fa-regular fa-pen-to-square"></i></a> <a
                            href="reg_profile.php? mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>"
                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                            title="View Member Profile"> <i class="fa-solid fa-id-card"></i></a></td>
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

  <script src="validate_member.js"></script>

  <?php include_once ('floating.php'); ?>


</body>

</html>