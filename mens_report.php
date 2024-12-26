<?php include_once('database_connection.php');



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
  <title>Mens Reports</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php include_once('navbar_men.php'); ?>
  <!-- /.navbar -->
  <?php include_once('mens_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Mens Welfare Report <?php echo date('Y') ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="card">
      <div class="card-body">
        <a href="report_men.php?mid=<?php echo $_GET['mid'] ?>" class="btn btn-primary" style="float:right;">Create & Send Report <i class="fa fa-receipt" ></i></a>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">

<div class="row">
<div class="col-6">
   <!-- BAR CHART -->
   <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Warefare Statistics <?php echo date('Y') ?> <i class='fa fa-line-chart'></i></h3>

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
                <div class="chart">
  <?php


     
$year = date('Y');
$query = $con->query("SELECT COUNT(amount) AS ct, month AS st FROM  dues WHERE status='Paid' AND year='$year' AND department='Men' GROUP BY month ");

foreach ($query as $row) {


  $stt[] = $row['st'];

  $ctt[] = $row['ct'];

 }
                ?>


                  <canvas id="bar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</div>

<div class="col-6">
   <!-- BAR CHART -->
   <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Unpaid Warefare - Statistics <?php echo date('Y') ?> <i class='fa fa-line-chart'></i></h3>

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
                <div class="chart">
  <?php


       
$year = date('Y');
$query = $con->query("SELECT COUNT(amount) AS ct, month AS st FROM  dues WHERE status='Unpaid' AND year='$year' AND department='Men' GROUP BY month ");

foreach ($query as $row) {


  $s[] = $row['st'];

  $c[] = $row['ct'];


                }
                ?>


                  <canvas id="dot" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</div>

</div>

      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card card-warning">
     <div class="card-header">
    <h3 class="card-title">Warefare from date to date <i class='fa fa-calendar'></i></h3>

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

   <form action="preview.php" method="post">
   <div class="row" style="margin-left: 40%;" >
    <div class="col-3">
    <div class="form-group">
      <label for="">From:</label>
      <input type="date" class="form-control" name="from">
     </div>
    </div>

    <div class="col-3">
    <div class="form-group">
      <label for="">To:</label>
      <input type="date" class="form-control" name="to" id="to">
     </div>
    </div>

    <div class="col-3">
    <div class="form-group">
      <label for="">Status:</label>
      <select name="status" id="" class="form-control">
        <option value="">-Select-</option>
        <option value="Paid">Paid</option>
        <option value="Unpaid">Unpaid</option>
      </select>
     </div>
    </div>

    <div class="col-3">
      <br>
    
     
     <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Fetch</button>
    </div>



    </div>

   </form>

      <table class="table table-hover" id="example4">
        <thead>
          <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Month</th>
            <th>Year</th>
            <th>Amount(¢)</th>
            <th>Date_Created</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
                
                  
                  $sql = "SELECT * from  dues where department='Men' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    $member_id   = $row['member_id'];
                    $member_name   = $row['fullname'];
                    $month = $row['month'];
                    $year   = $row['year'];
                    $amount = $row['amount'];
                    $status = $row['status'];
                    $date_created = $row['date_created'];
                      
           
                  ?>
          <tr>
            <td><?php echo $member_id; ?></td>
            <td><?php echo $member_name; ?></td>
            <td><?php echo $month; ?></td>
            <td><?php echo $year; ?></td>
            <td><?php echo number_format($amount,2) ?></td>
            <td><?php echo $date_created; ?></td>
            <?php 
            if($status === "Paid"){
              echo"<td><span class='badge badge-success'>Paid</span></td>";
            }else{
              echo"<td><span class='badge badge-danger'>Unpaid</span></td>";
            }
            ?>
           
          </tr>
          <?php    }
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

<?php include_once('youth_chart.php'); ?>
</body>
</html>
