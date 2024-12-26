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
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="youth_dashboard.php" class="nav-link">Home</a>
      </li>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php include_once('womens_sidebar.php'); ?>
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
           <a href="add_womens_expenses.php? uid=<?php echo uniqid(); ?> &mid=<?php echo $_GET['mid'] ?>">
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
            <a href="manage_womens_expenses.php?mid=<?php echo $_GET['mid']; ?>">
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
           <a href="womens_approved.php?mid=<?php echo $_GET['mid']; ?>">
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
           <a href="womens_rejected.php?mid=<?php echo $_GET['mid'];?>">
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

                    $query = $con->query("SELECT month AS ms,id, SUM(amount) sam FROM exepenses  WHERE year='$year' AND status='Approved' AND expense_type='Income' AND department='Women' GROUP BY month ORDER BY id ASC ");

                    foreach ($query as $row) {


                      $sy[] = $row['ms'];

                      $sam[] = $row['sam'];




                    }
                    ?>


                    <?php
                    $year = date('Y');

                    $query = $con->query("SELECT month AS ms1,id, SUM(amount) sam1 FROM exepenses  WHERE year='$year' AND status='Approved' AND expense_type='Expenditure' AND department='Women' GROUP BY month ORDER BY id ASC");

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


</body>
</html>
