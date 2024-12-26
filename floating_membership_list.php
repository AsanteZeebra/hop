<?php include_once ('database_connection.php'); 





session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
}
// Check if last activity was set
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3600) {
  session_unset(); // unset $_SESSION variable 
  session_destroy(); // destroy session data in storage
  header("Refresh:10"); //refresh
  header("Location: index.php"); // redirect to login page
 }
 $_SESSION['last_activity'] = time(); // update last activity time stamp
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floating Members</title>

    <?php include_once ('head.php'); ?>
</head>

<body>

    <br>
    <br>
    <br>
    <br>

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
                                <input disabled type="text" class="form-control tfid"  name="memid">
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


    <!-- Main content -->
    <section class="content">

        <h4 style="margin-left: 200px;">Move To</h4>
        <!-- Default box -->
        <div class="row">

            <div class="col-9" style="margin-left: 200px;">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover " table id="example1">
                            <thead>
                                <tr style="text-align:center">
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

                                            <td><button class="btn btn-primary btn-sm btm" data-toggle="modal"
                                                    data-target="#default">Move-to</button></td>


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


    <?php include_once ('footer.php'); ?>

    <!-- ./wrapper -->

    <?php include_once ('script.php'); ?>
    <?php include_once ('floating.php'); ?>
</body>

</html>