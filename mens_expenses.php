<?php include_once('database_connection.php');


include_once('load_session.php');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HOP | Expenses</title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php 
  $department = $_GET['dept'];
  switch ($department) {
    case 'Men':
        include_once('navbar_men.php');
        break;
    case 'Women':
        include_once('navbar_women.php');
        break;
    case 'Youth':
        include_once('navbar_youth.php');
        break;

    default:
        echo "No department specified";
        break;
  }
  
  ?>
  <!-- /.navbar -->
  <?php
  $department = $_GET['dept'];

  switch ($department) {
    case 'Men':
    include_once('mens_sidebar.php');
        break;
    case 'Women':
        include_once('womens_sidebar.php');
        break;
        case 'Youth':
        include_once('youth_sidebar.php');
            break;
    default:
        echo "No department specified";
        break;
  }
  
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Expenses</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Exepenses</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
   <!-- /.col -->
   <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" >

 <div class="col-12">
  <div class="card">
    <div class="card-body">
      
     
      <!-- Default box -->
    <div class="row" style="justify-content: center; margin-top:60px;" >
    <div class="col-md-3 col-sm-6 col-12" >
           <a href="add_mens_expenses.php? uid=<?php echo uniqid(); ?> &mid=<?php echo $_GET['mid'] ?>">
           <div class="info-box" style="background-color:#233F93">
              <span class="info-box-icon"><i class="fa-solid fa-plus" style="color: #ffffff;"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:white">Add Exepenses</span>
               
                <span class="info-box-number" style="color:white"></span>
               

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>

              </div>

              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <a href="manage_mens_expenses.php?mid=<?php echo $_GET['mid']; ?>">
            <div class="info-box " style="background-color: #C8A43E">
              <span class="info-box-icon"><i class="fa-solid fa-list-check" style="color:white"></i></span>

              <div class="info-box-content">
             
                <span class="info-box-text" style="color:white">Manage Expenses</span>
                <span class="info-box-number" style="color:white"> </span>
               

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>

              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
           <a href="mens_approved.php?mid=<?php echo $_GET['mid']; ?>">
           <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fa-solid fa-check-double"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:white">Approval Requests</span>
                <span class="info-box-number" style="color:white"></span> 
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>

 <div class="col-md-3 col-sm-6 col-12">
           <a href="mens_rejected.php?mid=<?php echo $_GET['mid'];?>">
           <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fa fa-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="color:white">Rejected Requests</span>
                <span class="info-box-number" style="color:white"></span> 
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
           </a>
            <!-- /.info-box -->
          </div>

         
  </div>
  </div>
  </div>


<div class="row">
  <div class="col-md-12">
     <!-- PIE CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Approved <?php echo date('Y') ?></h3>

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
              <?php


                    $year = date('Y');

                    $query = $con->query("SELECT month AS ms,id, SUM(amount) sam FROM exepenses  WHERE year='$year' AND status='Approved' AND expense_type='Income' AND department='Men' GROUP BY month ORDER BY id ASC ");

                    foreach ($query as $row) {


                      $sy[] = $row['ms'];

                      $sam[] = $row['sam'];




                    }
                    ?>


                    <?php
                    $year = date('Y');

                    $query = $con->query("SELECT month AS ms1,id, SUM(amount) sam1 FROM exepenses  WHERE year='$year' AND status='Approved' AND expense_type='Expenditure' AND department='Men' GROUP BY month ORDER BY id ASC");

                    foreach ($query as $row) {

                      $sam1[] = $row['sam1'];


                    }
                    ?>


<canvas id="dot" style="min-height: 250px; height: 350px; max-height: 800px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


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
<?php include_once("expenses_chart.php"); ?>
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
