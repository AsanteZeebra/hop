<?php
include_once ('database_connection.php');


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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Announcement</title>
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


            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Create Announcement
                                </h3>

                               
                            
                            </div>
                            <!-- /.card-header -->
                            <form method="post" id="atform">  
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                           <div class="form-group">
                                           <label for="">Tittle:</label> 
                                           <input type="text" name="saveas"class="form-control tfsave" placeholder="Tittle:">
                                           </div>
                                        </div>

                                        <div class="col-sm-4">
                                          <div class="form-group">
                                          <?php
                                            $member_id = $_GET['mid'];
                                            $sql = "SELECT * from  members WHERE member_id = '$member_id'";
                                            $result = mysqli_query($con, $sql);
                                            if ($result) {
                                                while ($row = mysqli_fetch_array($result)) {


                                                    $fullname = $row['fullname'];


                                                    ?>

                                                    <label for="">Name: </label> <input disabled type="text" name="name"
                                                        value="<?php echo $fullname; ?>" class="form-control tfname"
                                                        placeholder="Name">
                                                    <?php
                                                }
                                            } else {
                                                echo "No records found";
                                            }

                                            ?>

                                          </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="">ID#</label>
                                            <input disabled type="text" class="form-control tfid" name="id" value="<?php echo $_GET['mid']; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <textarea id="summernote" placeholder="Write your announcement here"class="form-control note"></textarea>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary sbtn" style="margin-left: 40%;"><i
                                            class="fa-regular fa-paper-plane"></i> Send Announcement</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col-->
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
    <?php include_once ('save_announcement.php'); ?>


</body>

</html>