<?php include_once ('database_connection.php');

include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Account & Roles </title>
  <?php include_once ('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include_once('navbar.php'); ?>
    <!-- /.navbar -->
    <?php include_once ('sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Account & Roles</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="modal fade" id="modal-lg">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" id="acform">


                  <div class="row">


                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Fullname</label>
                        <select class="form-control tfname select2" name="fullname">
                          <option value="">-Choose name-</option>
                          <?php

                          $sql = "SELECT * FROM members";
                          $run = mysqli_query($con, $sql);
                          if ($run) {
                            while ($row = mysqli_fetch_assoc($run)) {



                              $fullname = $row['fullname'];



                              ?>


                              <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>

                              <?php
                            }
                          } else {
                            echo "No records found";
                          }

                          ?>
                        </select>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Member ID</label>
                        <select class="form-control tfmemid  select2" name="memid">
                          <option value="">-Choose ID-</option>
                          <?php



                          $sql = "SELECT * FROM members";
                          $run = mysqli_query($con, $sql);
                          if ($run) {
                            while ($row = mysqli_fetch_assoc($run)) {


                              $mem_id = $row['member_id'];
                              $fullname = $row['fullname'];



                              ?>


                              <option value="<?php echo $mem_id ?>"><?php echo $mem_id ?>: <?php echo $fullname ?></option>

                              <?php
                            }
                          } else {
                            echo "No records found";
                          }

                          ?>
                        </select>
                      </div>
                    </div>

                 
                    <!-- form -->
                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Department</label>
                        <select class="form-control tfdepartment select2bs4" name="department">
                          <option value="">-Select-</option>
                          <option value="General Church">General Church</option>
                          <option value="Men's Department">Men's Department</option>
                          <option value="Women's Department">Women's Department</option>
                          <option value="Youth Department">Youth Department</option>
                          <option value="Childrens Department">Childrens Department</option>

                        </select>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Role:</label>
                        <select class="form-control tfrole select2bs4" name="role">
                          <option value="">-Select Role-</option>
                          <option value="Superadmin">Super Admin</option>
                          <option value="Subadmin">Sub Super Admin</option>
                          <option value="Warefareadmin">Warefare Admin</option>
                          <option value="Mensadmin">Men's Warefare Admin</option>
                          <option value="Womensadmin">Women's Warefare Admin</option>
                          <option value="Youthadmin">Youth Warefare Admin</option>
                          <option value="Attendance">Attendance</option>
                          <option value="Registration">Registration</option>
                          <option value="Childrensadmin">Childrens Admin</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Password:</label>
                        <input type="password" id="password" class='form-control tfpass' name="password">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <label for="name">Repeat Password:</label>
                        <input type="password" class='form-control tfrepeat' name="repeatpass">
                      </div>
                    </div>

                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
          </form>
        </div>
        <!-- /.modal -->
        <!-- Default box -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div>
                  <button class="btn btn-primary btn-sm" style="float:right" data-toggle="modal"
                    data-target="#modal-lg"><i class="fa fa-plus"></i> Add User</button>
                </div>
                <br>
                <br>

                <table class='table table-hover' id="example1">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Membe_id</th>
                      <th>Role</th>
                      <th>Date_created</th>
                      <th><i class='fa fa-bars'></i></th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM account";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {


                        $mem_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $role = $row['role'];
                        $date_created = $row['date_created'];
                        



                        ?>
                        <tr>
                          <td><?php echo $fullname ?></td>
                          <td><?php echo $mem_id ?></td>
                          <?php if ($role === "Superadmin") {
                            echo " <td><span class='badge badge-success'>$role</span></td>";
                          } elseif ($role === "Warefareadmin") {
                            echo " <td><span class='badge badge-dark'>$role</span></td>";
                         
                          } elseif ($role === "Mensadmin") {
                            echo " <td><span class='badge badge-primary'>$role</span></td>";
                         
                          } elseif ($role === "Womensadmin") {
                            echo " <td><span class='badge badge-info'>$role</span></td>";
                        
                          } elseif ($role === "Youthadmin") {
                         echo " <td><span class='badge badge-warning'>$role</span></td>";
                        } elseif ($role === "Attendance") {
                          echo " <td><span class='badge badge-light'>$role</span></td>";
                         
                          }elseif ($role === "Childrensadmin") {
                            echo " <td><span class='badge badge-danger'>$role</span></td>";
                          }elseif($role ==="Registration"){
                            echo " <td><span class='badge badge-danger'>$role</span></td>";
                          }

                          ?>

                          <td><?php echo $date_created; ?></td>
                          <td><a href="#" class="btdel"><i
                                class='fa-regular fa-trash-can text-muted'></i></a></td>

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

        <div class="card card-success">
                   <div class="card-header">
                <h3 class="card-title">Ativity Logs</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
                   <div class="card-body">
            <table  class="table">
            <thead>
           <tr>
           <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>login time</th>
            <th>logout time</th>
            <th>Status</th>
           </tr>
            </thead>
            <tbody>
            <?php



$sql = "SELECT * FROM activity_logs LIMIT 10 ";
$run = mysqli_query($con, $sql);
if ($run) {
  while ($row = mysqli_fetch_assoc($run)) {


    $mem_id = $row['member_id'];
    $fullname = $row['fullname'];
    $role = $row['role'];
    $login_time = $row['login_time'];
    $logout_time = $row['logout_time'];
    $status = $row['status'];
    ?>
<tr> 
  <td><?php echo $mem_id; ?></td>
  <td><?php echo $fullname; ?></td>
  <td><?php echo $role; ?></td>
  <td><?php echo $login_time; ?></td>
  <td><?php echo $logout_time; ?></td>
  <?php
  if($status === "logged_in"){
    echo " <td><i class='fa-solid fa-circle-dot' style='color:green'></i> Online</td>";
  }else if($status === "logged_out"){
    echo " <td><i class='fa-solid fa-circle-dot' style='color:#FFC107'></i> Offline</td>";
  }
  ?>
  
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
                <form method="post">
                  <div class='row'>
                    <div class='col-4'>
                      <input type="text" class='form-control ddt'>
                    </div>


                  </div>
                  <center>
                    <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger bbt">Yes</button>
                  </center>
                </form>

              </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


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
  <script src="validate_account.js"></script>

</body>

</html>