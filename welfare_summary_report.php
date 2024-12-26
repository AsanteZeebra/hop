<?php 
include_once('database_connection.php');


include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Today's report | Welfare </title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     

    <li class="nav-item">
    <?php
                 
                  
                 $sql = "SELECT SUM(amount) AS money FROM dues WHERE status='Paid' ";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['money'];
                 
                 ?>
      <b class="nav-link">Balance: ¢<?php echo number_format($amount,2) ?></b>
      <?php    }
                  } else {
                    echo "No Record Found!";
                  } ?>
      </li>
      
      
      <li class="nav-item">
        <a class="nav-link"  href="signout.php" role="button">
        <i class="fa-solid fa-arrow-right-from-bracket"></i> logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php include_once('welfare_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Welfare</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Welfare</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card">
    <div class="card-body">
<center>
<img src="dist/img/hop1.png" alt="hop-logo" style="width:180px; height:180px; ">  <br>  
<b style="font-size:30px">Welfare Report</b> <br>
<b style="font-size:20px"><?php echo date("Y-M-jS"); ?> Week <?php echo date("W"); ?> </b> 
<hr style="background-color:black">
</center>
<br>
    <table class="table" >
        <thead>
           <tr>
         
            
            <th>Month</th>
            <th>Year</th>
            <th>Amount</th>
            <th>Paid_on</th>
           </tr>
    </thead>
    <tbody>
    <?php
                $today =  date("Y-M-jS"); 
                  
                 $sql = "SELECT * FROM dues WHERE status='Paid' AND date_created='$today'  GROUP BY department";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['amount'];
                  
                   $department = ($row['department']);
                   $month = $row['month'];
                   $year = $row['year'];
                   
                 
                 ?>
<tr>
    
    <td><b><?php echo $department ?></b></td>
    <td><?php echo $month ?></td>
    <td><?php echo $year ?></td>
    <td><?php echo number_format($amount,2) ?></td>
  
</tr>
<?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
    </tbody>
   
    </table>
<br>

    <table class="table" style="float: Right; width:30%">
        <tr>
        <?php
                $today =  date("Y-M-jS"); 
                  
                 $sql = "SELECT SUM(amount) AS total FROM dues  where status='Paid'  ";
                 $result = mysqli_query($con, $sql);
                 if ($result) {
                   while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['total'];

                 ?>
            <td><b style="font-size: 25px">Total(¢): <?php echo  number_format($amount,2) ?></b> </td>
            <?php    }
                  } else {
                    echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
                  } ?>
        </tr>
        <tr>
            <td></td>
        </tr>
       
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

<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
