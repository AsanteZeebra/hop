<?php
include_once('database_connection.php');


include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Announcement </title>
  <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include_once('navbar.php'); ?>
    <!-- /.navbar -->
    <?php include_once('sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Announcement</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">announcement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">

          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <a href="create_announcement.php?mid=<?php echo $_GET['mid']; ?>" class="btn btn-primary btn-sm"
                  style="float:right">Add New</a>
                <br><br>
                <table class="table" id="example4">
                  <thead>
                    <tr>

                      <th hidden>#ID</th>
                      <th>Tittle</th>
                      <th>Department</th>
                      <th>Status</th>
                      <th>date_created</th>
                      <th><i class="fa fa-bars"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    $mem_id = $_GET['mid'];


                    $sql = "SELECT * FROM announcement";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                      while ($row = mysqli_fetch_assoc($run)) {



                        $report_id = $row['id'];
                        $description = $row['tittle'];
                        $department = $row['department'];
                        $status = $row['status'];
                        $date_created = $row['date_created'];




                        ?>
                        <tr>

                          <td hidden><a href="#"><?php echo $report_id; ?></a></td>
                          <td><a
                              href="view_announcement.php?rid=<?php echo $report_id; ?> &mid=<?php echo $mem_id; ?>"><?php echo $description ?></a>
                          </td>
                          <td><?php echo $department ?></td>

                          <?php if ($status === "Active") {
                            echo "  <td><label class='badge badge-success'>$status</label></td>";
                          } elseif ($status === "Pending") {
                            echo "  <td><label class='badge badge-warning'>$status</label></td>";
                          } else {
                            echo "  <td><label class='badge badge-error'>$status</label></td>";
                          }

                          ?>
                          <td><?php echo $date_created ?></td>
                          <td><a href="#"><i class='fa-regular fa-pen-to-square text-muted'></i></a> <a href="#"
                              class="btdel"><i class='fa-regular fa-trash-can text-muted'></i></a></td>
                        </tr>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
                  </tbody>
                </table>

              </div>
            </div>
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

    <?php include_once('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->


  <?php include_once("script.php"); ?>

  <script src="validate_announcement.js"></script>
</body>

</html>