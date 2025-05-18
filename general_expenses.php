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
<?php include_once('navbar_general.php'); ?>
  <?php include_once('general_sidebar.php'); ?>
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
    <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>
    <!-- Main content -->
    <section class="content">
  <!-- Dashboard Container -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <!-- Action Buttons Row -->
          <div class="row justify-content-center mt-5">
            <!-- Create Button -->
            <div class="col-md-2 col-sm-6 col-12">
              <a href="add_expenses.php?uid=<?php echo uniqid(); ?>&mid=<?php echo $_GET['mid']; ?> &&dept=<?php echo $_GET['dept']; ?>">
                <div class="info-box bg-primary">
                  <span class="info-box-icon text-white"><i class="fa-solid fa-plus"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text text-white">Create</span>
                  </div>
                </div>
              </a>
            </div>

            <!-- Manage Button -->
            <div class="col-md-2 col-sm-6 col-12">
              <a href="manage_general_expenses.php?mid=<?php echo $_GET['mid']; ?>">
                <div class="info-box bg-warning">
                  <span class="info-box-icon text-white"><i class="fa-solid fa-list-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text text-white">Manage</span>
                  </div>
                </div>
              </a>
            </div>

            <!-- Approvals Button -->
            <div class="col-md-2 col-sm-6 col-12">
              <a href="approved_expenses.php?mid=<?php echo $_GET['mid']; ?>">
                <div class="info-box bg-success">
                  <span class="info-box-icon text-white"><i class="fa-solid fa-check-double"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text text-white">Approvals</span>
                  </div>
                </div>
              </a>
            </div>

            <!-- Rejected Button -->
            <div class="col-md-2 col-sm-6 col-12">
              <a href="rejected_expenses.php?mid=<?php echo $_GET['mid']; ?>">
                <div class="info-box bg-danger">
                  <span class="info-box-icon text-white"><i class="fa fa-times"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text text-white">Rejected</span>
                  </div>
                </div>
              </a>
            </div>

            <!-- Reports Button -->
            <div class="col-md-2 col-sm-6 col-12">
              <a href="expenses_report.php?mid=<?php echo $_GET['mid']; ?>">
                <div class="info-box bg-dark">
                  <span class="info-box-icon text-white"><i class="fa fa-receipt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text text-white">Reports</span>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Approved Chart Section -->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Approved Expenses - <?php echo date('Y'); ?></h3>
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
                $queryApproved = $con->query("SELECT month AS ms, SUM(amount) AS sam FROM exepenses WHERE year='$year' AND status='Approved' AND expense_type='Income' AND department='Main' GROUP BY month ORDER BY id ASC");
                foreach ($queryApproved as $row) {
                  $sy[] = $row['ms'];
                  $sam[] = $row['sam'];
                }

                $queryExpenditure = $con->query("SELECT month AS ms1, SUM(amount) AS sam1 FROM exepenses WHERE year='$year' AND status='Approved' AND expense_type='Expenditure' AND department='Main' GROUP BY month ORDER BY id ASC");
                foreach ($queryExpenditure as $row) {
                  $sam1[] = $row['sam1'];
                }
              ?>
              <canvas id="dot" style="min-height: 250px; height: 350px; max-height: 800px; max-width: 100%;"></canvas>
            </div>
          </div>
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
