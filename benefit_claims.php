<?php
include_once('database_connection.php');


include_once('load_session.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome|HOP|Dashboard|</title>

 <?php include_once("head.php"); ?>
</head>
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/hop1.png" alt="logo" height="60" width="60">
  </div>

  <!-- Navbar -->
   <?php 
   $department = $_GET['dept'];

   switch ($department) {
    case 'Men':
        include_once('navbar_men.php'); 
        break;
    case 'Main':
        include_once('navbar_general.php'); 
        break;
    case 'Women':
    include_once('navbar_women.php'); 
        break;
        case 'Youth':
         include_once('navbar_youth.php'); 
            break;
    default:
        echo 'Departments not found.';
        break;
   }
   ?>
 
  <!-- /.navbar -->


  <!-- Sidebar -->
<?php 
$department = $_GET['dept'];
switch ($department) {
    case 'Men':
       include_once('mens_sidebar.php');
        break;
    case 'Main':
       include_once('general_sidebar.php');
        break;
    case 'Youth':
        include_once('youth_sidebar.php');
        break;
    case 'Women':
        include_once('womens_sidebar.php');
        break;
    default:
        # code...
        break;
}





?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Benefits - <?php echo $_GET['dept'] ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">  
          <div class="col-12 col-sm-6 col-md-3">
           <a href="#" style="color:black">
           <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Requests</span>
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT COUNT(DISTINCT member_id) AS total FROM benefits WHERE department='$department' ";
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
           </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3"> 
           <a href="#" style="color:black">
           <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM benefits WHERE department='$department' AND status='Rejected' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <a href="#" style="color:black">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Approved</span>
                <?php
                $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM benefits WHERE department='$department' AND status='Approved' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
           
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
        <a href="#" style="color:black">
        <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-file-invoice" style="color:white"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Amount Released(¢)</span>

               <?php
               $department = $_GET['dept'];
                    $sql = "SELECT SUM(amount) AS total FROM benefits WHERE department='$department' AND status='Approved' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
                        <span class="info-box-number">¢<?php echo number_format($count,2) ?></span>
                      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

        </a>  
        </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


        <div class="modal fade" id="benefit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Benefit Claim</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <form method="post">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="">Fullname</label>
                  <select name="" id="" class="form-control select2bs4">
                    <option value="">--choose--</option>
                    <option value="Asant Michael">Asante Michael</option>
                  </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="">Member ID</label>
                  <select name="" id="" class="form-control select2bs4">
                    <option value="">--choose--</option>
                    <option value="1256699">12345699</option>

                  </select>
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="">Benefit_type</label>
                  <select name="" id="" class="form-control select2bs4">
                    <option value="">--choose--</option>
                    <option value="Child birth">Childer birth</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Health">Health</option>
                    <option value="Funeral">Funeral</option>
                    <option value="Others">Others</option>
                  </select>
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="">Amount</label>
                 <input type="number" class="form-control" required>
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="">telephone</label>
                 <input type="text" class="form-control" required>
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                    <label for="">Address</label>
                <textarea name="" id="" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="">Comment</label>
                <textarea name="" id="" class="form-control"></textarea>
                  </div>
                </div>


              </div>
             </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Submmit</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                 <h5 class="card-title">Transactions</h5> 

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                  <div class="btn-group">
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                   <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#benefit" style="float:right;"><i class="fa fa-plus"></i> New Request</button>
               <br>
               <br>

                   <table class="table table-hover" id="example1">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Benefit_type</th>
                       <th>Amount(¢)</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>125</td>
                      <td>Asante Michael</td>
                      <td>Main</td>
                      <td>Wedding benefit</td>
                      <td>¢2000.00</td>
                      <td>Approved</td>
                      <td><a href="#" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a> <a href="benefit_receipt.php? dept=<?php echo $_GET['dept'] ?> && mid=<?php echo $_GET['mid'] ?>" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> </td>
                    </tr>
                  </tbody>
                </table>
                  
                  </div>
                
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
              
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
         

          <div class="col-md-4">
          
          
            


            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php include_once('footer.php'); ?>
</div>
<!-- ./wrapper -->

<?php include_once('script.php'); ?>
<?php include_once('mens_chart.php'); ?>


</body>
</html>
