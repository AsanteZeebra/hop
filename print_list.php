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
                    <h4 class="modal-title">Add to </h4>
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

       
        <!-- Default box -->
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover ">
                            <thead style="background-color: #383838; color:white;">
                                <tr style="text-align:center">
                                    <th><i class="fa fa-image"></i></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Telephone</th>
                                    
                                    <th>Marital_status</th>
                                    <th>Age</th>
                                    <th>Occupation</th>
                                   

                                </tr>
                            </thead>

                            <tbody>
                                <?php


                                $sql = "SELECT * from  members ";
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
                                        $children = $row['number_of_children'];

                                        ?>
                                        <tr style="text-align:center">
                                            <?php 
                                            if(!empty($photo)){
                                                echo "<td><img src='uploads/$photo' alt='img' style='width: 80px; height: 80px;'></td>";
                                            }else {
                                                echo " <td><img src='dist/img/user.png' alt='img' style='width: 80px; height: 80px;'></td>";
                                            }
                                            ?>
                                           
                                            <td><a href="#"><?php echo $member_id; ?></a></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $telephone; ?> <br> <small><?php echo $residence_address; ?> </small></td>
                                            
                                            <td><?php echo $marital; ?> <br> <small><?php echo $children; ?> child/ren</small></td>
                                            <td><?php echo $age; ?>Years</td>
                                            <td><?php echo $occupation; ?></td>

                                           
                                        </tr>

                                    <?php }
                                } else {
                                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                                } ?>
                            </tbody>
                            <?php


$sql = "SELECT COUNT(*) AS total from  members ";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
      
       
        $total = $row['total'];
     
        ?>
                            <tfoot style="background-color: #383838; color:white;">
                                <tr style="text-align:center">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    
                                    <th></th>
                                    <th></th>
                                    <th>Total: <?php echo $total ?></th>
                                   

                                </tr>
                            </tfoot>
                            
                            <?php }
                                } else {
                                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                                } ?>
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
    <script>
  window.addEventListener("load", window.print());
</script>

</body>

</html>