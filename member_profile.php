<?php 
include_once('database_connection.php');
include_once('check_ages.php');

include_once('load_session.php');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Members Profile</title>
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Members</h1>
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

    <button class="btn btn-primary btn-sm back" style="margin-left: 20px;"><i class="fa fa-arrow-left"></i> Back</button>  
    <br>
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

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

      if($photo === ""){
         
echo "<img class='profile-user-img img-fluid img-circle' src='dist/img/user.png' alt='User profile picture' style='width:130px; height: 135px;'>";

      }else {
  
echo " <img class='profile-user-img img-fluid img-circle' src='uploads/$photo' alt='User profile picture' style='width:130px; height: 135px;'>";

      }

}
}
                               
                               ?>
                </div>

                <?php
                  include_once('database_connection.php');
                  $mem_id = $_GET['uid'];
                  $sql = "SELECT id,fullname,age,member_id,telephone,dob,residense_address,status,position,next_of_kin,YEAR(dob) as year,alter_call,marital_status,gender,occupation,spouse,number_of_children,city,region,postal_address,date_created from  members WHERE member_id='$mem_id' ORDER BY fullname ASC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['id'];
                      $member_id = $row['member_id'];
                      $fullname = $row['fullname'];
                      $telephone = $row['telephone'];
                      $residence_address = $row['residense_address'];
                      $status = $row['status'];
                      $position = $row['position'];
                      $next_of_kin = $row['next_of_kin'];
                      $dob = $row['dob'];
                      $old_year = $row['year'];
                      $alter_call = $row['alter_call'];
                      $marital_status = $row['marital_status'];
                      $gender = $row['gender'];
                      $occupation = $row['occupation'];
                      $spouse = $row['spouse'];
                      $children = $row['number_of_children'];
                      $city = $row['city'];
                      $region = $row['region'];
                      $postal_address = $row['postal_address'];

                      $current_age = $row['age'];


           
                  ?>

                <h3 class="profile-username text-center"><?php echo $fullname; ?></h3>

                <p class="text-muted text-center"><?php echo $residence_address; ?> </p>

                <ul class="list-group list-group-unbordered mb-3">
                 
                  <li class="list-group-item">
                    <b>Position</b> <a class="float-right"><?php echo $position; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status </b> <a class="float-right"> <i class='fa-regular fa-circle-check' style='color:green'></i> <?php echo $status; ?> </a>
                  </li>
                </ul>

               <div class="row"> 
                <div class="col-6"><a href="edit_profile.php?mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>" class="btn btn-primary btn-block"><i class="fa-solid fa-pen"></i> Edit</a>
                </div>
               <div class="col-6">
               <a href="proview.php?mid=<?php echo $_GET['mid']; ?>&uid=<?php echo $member_id; ?>" class="btn btn-primary btn-block" ><i class="fa-solid fa-print"></i> Print</a>
             
               </div>
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              

              
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $residence_address; ?></p>

                <hr>

                <strong><i class="fa-solid fa-phone mr-1"></i> Telephone</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?php echo $telephone; ?></span>
                  
                
                </p>

                <hr>

                <strong><i class="fa-solid fa-user-group mr-1"></i> Next of kin</strong>

                <p class="text-muted"><?php echo $next_of_kin; ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-9">
            <div class="card card-primary card-outline">
              
              <div class="card-body">
                
               
              <table class="table table-borderless">
    <thead>
        <tr>
            <th>Member #ID</th>
            <th>Date Added</th>
            <th>House Address</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['date_created']; ?></td>
            <td><?php echo $row['residense_address']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    </tbody>
</table>
               
<br>
<div class="row">
<div class="col-sm-2"><b><h4>Personal Info </h4></b> </div> <div class="col-sm-10"><hr style="background-color: #505050;"></div>
</div>
<div class="row">
    <div class="col-sm-10">
        <table class="table ">
            <tr>
                <td>Fullname</td>
                <td>Region</td>
                <td>Marital Status</td>
                <td>Age</td>
            </tr>
            <tr>
                <td><b><?php echo $row['fullname']; ?></b></td>
                <td><b><?php echo $row['region']; ?></b></td>
                <td><b><?php echo $row['marital_status']; ?></b></td>
                <td><b><?php echo $row['age']; ?> Years</b></td>
            </tr>
            <tr>
                <td>Date of birth</td>
                <td>Occupation</td>
                <td>House Address</td>
                <td>Telephone</td>
            </tr>
            <tr>
                <td><b><?php echo $row['dob']; ?></b></td>
                <td><b><?php echo $row['occupation']; ?></b></td>
                <td><b><?php echo $row['residense_address']; ?></b></td>
                <td><b><?php echo $row['telephone']; ?></b></td>
            </tr>
            <tr>
                <td>Date of 'Alter Call'</td>
                <td>gender</td>
                <td>Position</td>
                <td>City/Town</td>
            </tr>
            <tr>
                <td><b><?php echo $row['alter_call']; ?></b></td>
                <td><b><?php echo $row['gender']; ?></b></td>
                <td><b><?php echo $row['position']; ?></b></td>
                <td><b><?php echo $row['city']; ?></b></td>
            </tr>
            <tr>
                <td>Spouse Name</td>
                <td>Number of Children</td>
                <td>Next of kin</td>
                <td></td>
            </tr>
            <tr>
                <td><b><?php echo $row['spouse']; ?></b></td>
                <td><b><?php echo $row['number_of_children']; ?></b></td>
                <td><b><?php echo $row['next_of_kin']; ?></b></td>
                <td><b></b></td>
            </tr>
        
        </table>
    </div>

    <div class="col-sm-2">
        <img src="uploads/bff.jpg" alt="" style="with: 150px; height: 150px;">
    </div>
</div>




<?php }
                  } else {
                    echo "No Record Found!";
                  } ?>        

              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
