<?php

include_once('database_connection.php');

include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member's Profile | <?php echo $_GET['uid'] ?></title>
    <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once('reg_navbar.php') ?>
        <!-- /.navbar -->
        <?php include_once('reg_sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">edit_profile</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <button class="btn btn-primary btn-sm back" style="margin-left: 20px;"><i class="fa fa-arrow-left"></i> Back</button>  
    <br>
    <br>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">

                    <div class="col-3">
                        <?php
                        include_once('database_connection.php');

                        $member_id = $_GET['uid'];

                        $sql = "SELECT * from  members WHERE member_id = '$member_id'";
                        $result = mysqli_query($con, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_array($result)) {


                                $fullname = $row['fullname'];
                                $date_of_birth = $row['dob'];
                                $altercall = $row['alter_call'];
                                $gender = $row['gender'];
                                $marital_status = $row['marital_status'];
                                $occuptation = $row['occupation'];
                                $telephone = $row['telephone'];
                                $age = $row['age'];
                                $spouse = $row['spouse'];
                                $number_of_childern = $row['number_of_children'];
                                $city = $row['city'];
                                $region = $row['region'];
                                $residence_address = $row['residense_address'];
                                $postal_address = $row['postal_address'];
                                $next_of_kin = $row['next_of_kin'];
                                $status = $row['status'];
                                $position = $row['position'];
                                $age = $row['age'];
                                ?>

                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <?php

                                            $idd = $_GET['uid'];

                                            $sqlc = " SELECT *  FROM members WHERE member_id='$idd'";
                                            $execute = mysqli_query($con, $sqlc);
                                            if ($execute) {
                                                while ($row = mysqli_fetch_array($execute)) {
                                                    $photo = $row['file_name'];

                                                    if ($photo === "") {

                                                        echo "<img class='profile-user-img img-fluid img-circle' src='dist/img/user.png' alt='User profile picture' style='width:130px; height: 135px;'>";

                                                    } else {


                                                        echo " <img class='profile-user-img img-fluid img-circle' src='uploads/$photo' alt='User profile picture' style='width:130px; height: 135px;'>";


                                                    }

                                                }
                                            }

                                            ?>
                                        </div>

                                        <a href="#">
                                            <h3 class="profile-username text-center" data-toggle="modal" data-target="#mdpay">
                                                <?php echo $fullname; ?></h3>
                                        </a>

                                        <p class="text-muted text-center"><?php echo $position; ?></p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Age</b> <a class="float-right"><?php echo $age; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Position</b> <a class="float-right"> <?php echo $position; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Status</b> <a class="float-right"> <?php echo $status; ?></a>
                                            </li>
                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">About</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <strong><i class="fas fa-home mr-1"></i> House Address</strong>

                                        <p class="text-muted">
                                            <?php echo $residence_address; ?>, <?php echo $city; ?>
                                        </p>

                                        <hr>

                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Postal Address</strong>

                                        <p class="text-muted"><?php echo $postal_address; ?></p>

                                        <hr>

                                        <strong><i class="fas fa-phone-alt mr-1"></i> Telephone</strong>

                                        <p class="text-muted">
                                            <span class="tag tag-danger"><?php echo $telephone; ?></span>

                                        </p>


                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->

                            <!-- Modal box -->
                            <div class="modal fade" id="preview">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Profile Preview <br>
                                                <span style='font-size:14px' class="text-muted">You made changes to these
                                                    informations. Are you sure you want to save? </span>
                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                           
                                            <table style="width:100%">
                                                <tr>
                                                    <td><b>FullName:</b></td>
                                                    <td><?php echo $fullname ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Date of Birth::</b></td>
                                                    <td><?php echo $date_of_birth ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Age::</b></td>
                                                    <td><?php echo $age ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Date of 'Alter Call':</b></td>
                                                    <td><?php echo $altercall ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender:</b></td>
                                                    <td><?php echo $gender ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Marital Status:</b></td>
                                                    <td><?php echo $marital_status ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Occupation:</b></td>
                                                    <td><?php echo $occuptation ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Telephone:</b></td>
                                                    <td><?php echo $telephone ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Spouse Name:</b></td>
                                                    <td><?php echo $spouse ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. of Children:</b></td>
                                                    <td><?php echo $number_of_childern ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>City:</b></td>
                                                    <td><?php echo $city ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Region:</b></td>
                                                    <td><?php echo $region ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Residence Address:</b></td>
                                                    <td><?php echo $residence_address ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Postal Address:</b></td>
                                                    <td><?php echo $postal_address ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Next Of Kin:</b></td>
                                                    <td><?php echo $next_of_kin ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Position:</b></td>
                                                    <td><?php echo $position ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary upbtn">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

                            <!-- Delete profile modal -->
                            <div class="modal fade" id="mdquestion" style="margin-top: 15%;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="width: 100%; text-align: center;">Are you Sure Want
                                                to Delete<i class="fa fa-question"></i></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
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



                            <!-- Upload Photo -->

                            <div class="modal fade" id="mdpay">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#343A40;">
                                            <h4 class="modal-title" style="color: white;"><i class="fa fa-upload"
                                                    style="color: white;"></i>Upload Photo</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="col-lg-12">

                                                <div class="panel" style="border-style:dotted; border-radius:10px;">
                                                    <div class="image_upload_div">
                                                        <form action="save_photo.php" class="dropzone">
                                                            <input hidden type="text" disabled class='form-control tfid'
                                                                value="<?php echo $_GET['uid']; ?>">
                                                            <div class="dz-message">
                                                                Drop files here or click to upload. <i
                                                                    class="text-muted fa fa-upload"></i><br>
                                                                <small class="text-muted">Accepted files: .jpg,.JPEG,.png not
                                                                    more than 4MB</small>
                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <div class="float-right">

                                                    <button type="button" id="startUpload" class="btn btn-primary"><i
                                                            class="fa fa-upload"></i> Upload</button>
                                                </div>
                                                <button type="reset" class="btn btn-default " data-dismiss="modal"><i
                                                        class="fas fa-times"></i> Close</button>
                                                </form>
                                            </div>

                                            <!-- /.card-footer -->

                                        </div>

                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

                            <div class="col-9">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Member's Profile</h3>
                                    </div>
                                    <div class="card-body">



                                        <form method="post" id="form000">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-default">

                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="bs-stepper">
                                                            <div class="bs-stepper-header" role="tablist">
                                                                <!-- your steps here -->
                                                                <div class="step" data-target="#logins-part">
                                                                    <button type="button" class="step-trigger" role="tab"
                                                                        aria-controls="logins-part" id="logins-part-trigger">
                                                                        <span class="bs-stepper-circle"><i
                                                                                class="fa-regular fa-user"></i></span>
                                                                        <span class="bs-stepper-label">Personal
                                                                            information</span>
                                                                    </button>
                                                                </div>
                                                                <div class="line"></div>
                                                                <div class="step" data-target="#information-part">
                                                                    <button type="button" class="step-trigger" role="tab"
                                                                        aria-controls="information-part"
                                                                        id="information-part-trigger">
                                                                        <span class="bs-stepper-circle"><i
                                                                                class="fa-solid fa-users"></i></span>
                                                                        <span class="bs-stepper-label">Family information</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="bs-stepper-content">
                                                                <!-- your steps content here -->
                                                                <div id="logins-part" class="content" role="tabpanel"
                                                                    aria-labelledby="logins-part-trigger">
                                                                    <div class="form-group">
                                                                        <label for="">FullName</label>
                                                                        <input type="text" class="form-control tfname"
                                                                            value="<?php echo $fullname ?>"
                                                                            placeholder="Enter FullName">
                                                                    </div>

                                                                    <div class="row">

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Date of Birth:</label>

                                                                                <input type="date" class="form-control  tfdob"
                                                                                    value="<?php echo $date_of_birth ?>">


                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="">Age:</label>
                                                                                <input type="text" class="form-control tfage"
                                                                                    value="<?php echo $age ?>"
                                                                                    placeholder="Age">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label>Date of 'Alter call':</label>

                                                                                <input type="date" class="form-control tfalter"
                                                                                    value="<?php echo $altercall ?>"
                                                                                    data-target="" />


                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="">Gender</label>
                                                                                <select class="form-control cbgender">
                                                                                    <option selected="selected">
                                                                                        <?php echo $gender ?>
                                                                                    </option>
                                                                                    <option>Male</option>
                                                                                    <option>Female</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="">Marital Status</label>
                                                                                <select class="form-control cbmarital">
                                                                                    <option selected="selected">
                                                                                        <?php echo $marital_status ?>
                                                                                    </option>
                                                                                    <option>Single</option>
                                                                                    <option>Married</option>
                                                                                    <option>Divorced</option>
                                                                                    <option>Widowed</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="">Occupation</label>
                                                                                <input type="text"
                                                                                    class="form-control tfoccupation"
                                                                                    value="<?php echo $occuptation ?>"
                                                                                    placeholder="Occupation">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="">Telephone</label>
                                                                                <input type="text" class="form-control tftel"
                                                                                    value="<?php echo $telephone ?>"
                                                                                    placeholder="Telephone">

                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="stepper.next()">Next</button>
                                                                </div>
                                                                <div id="information-part" class="content" role="tabpanel"
                                                                    aria-labelledby="information-part-trigger">


                                                                    <div class="form-group">
                                                                        <label for="exampleInputPassword1">Spouse Name</label>
                                                                        <input type="text" class="form-control tfspouse"
                                                                            value="<?php echo $spouse ?>"
                                                                            placeholder="Name of Husband / Wife">
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="">No. of Children</label>
                                                                                <input type="text" class="form-control tfchild"
                                                                                    value="<?php echo $number_of_childern ?>"
                                                                                    placeholder="Number of children">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="">City/Town</label>
                                                                                <input type="text" class="form-control tfcity"
                                                                                    value="<?php echo $city ?>"
                                                                                    placeholder="City/Town">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="">Region</label>
                                                                                <input type="text" class="form-control tfregion"
                                                                                    value="<?php echo $region ?>"
                                                                                    placeholder="Region">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <div class="form-group">
                                                                                <label for="">Residence Address</label>
                                                                                <textarea class="form-control tfresidence"
                                                                                    cols="30" rows="3"
                                                                                    placeholder="House address / city or town"><?php echo $residence_address ?></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="">Postal Address</label>
                                                                                <textarea class="form-control tfpostal"
                                                                                    cols="30" rows="3"
                                                                                    placeholder="P.O.Box"><?php echo $postal_address ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="">Next of kin:</label>
                                                                            <input type="text" class="form-control tfnextofkin"
                                                                                value="<?php echo $next_of_kin ?>"
                                                                                placeholder="Next of kin">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="">Position</label>
                                                                            <input type="text" class="form-control tfposition"
                                                                                value="<?php echo $position ?>"
                                                                                placeholder="Position">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12" hidden>
                                                                        <div class="form-group">
                                                                            <label for="">ID</label>
                                                                            <input  type="text" class="form-control tfid"
                                                                                value="<?php echo $member_id ?>"
                                                                                placeholder=" Member ID">
                                                                        </div>
                                                                    </div>

                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="stepper.previous()">Previous</button>
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#preview">Continue</button>
                                                                    <button type="button" class="btn btn-danger"
                                                                        style="float: right;" data-target="#mdquestion"
                                                                        data-toggle="modal">Delete
                                                                        Profile</button>
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

                                <?php }
                        } else {
                            echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                        } ?>
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

    <script src="update_members.js?T=123"></script>

    <script>
  
  $('.back').click(function(){
    if (document.referrer) {
      window.location.href = document.referrer;
  } else {
      window.history.back();
  }

  });

</script>
</body>

</html>