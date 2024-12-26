<?php include_once('database_connection.php');
include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Youth Dues Records</title>
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
        <a href="youth_dashboard" class="nav-link">Home</a>
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
  <?php include_once('youth_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      <?php

$mem_id = $_GET['idd'];
     $sql = "SELECT COUNT(month) as month,fullname FROM dues WHERE member_id='$mem_id' AND status='Unpaid'  AND department='Youth'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        $mname= $row['fullname'];
        $wk = $row['month'];
       

     ?>


<?php 
if($wk === '0'){

}else{
  
}
?>
      <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
            <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Notice!</h5>
                  <?php echo $mname ?> has Unpaid dues for the past <?php echo $wk ?> month/s
                </div>

                <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>

                
       <!-- /.col -->
<div class="col-12">
           
            <?php

$mem_id = $_GET['idd'];
     $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
         $member_name = $row['fullname'];
        $address = $row['residense_address'];
        $telephone = $row['telephone'];
       

     ?>
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-primary">
                <h3 class="widget-user-username"><?php echo $member_name; ?></h3>
                <h5 class="widget-user-desc"><?php echo $address; ?></h5>
              </div>
              <div class="widget-user-image">
              <?php

$mem_id = $_GET['idd'];
     $sql = "SELECT * FROM photos WHERE member_id='$mem_id' ";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
         $photo = $row['file_name'];
       
       

     ?>
                <img class="img-circle elevation-2" src="uploads/<?php echo $photo ?>" alt="User Avatar" style="height:105px; width: 105px;">

                <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?php echo $telephone ?></h5>
                      <span class="description-text">TELEPHONE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                    <?php
                    $mem_id = $_GET['idd'];
                  $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $status = $row['status'];
                  ?>
                      <h5 class="description-header">Member Status</h5>
                      <span class="description-text"><?php echo $status; ?></span>
                      
                      <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>


                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                    <?php
                    $mem_id = $_GET['idd'];
                  $sql = "SELECT * FROM members WHERE member_id='$mem_id' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $position = $row['member_id'];
                  ?>
                      <h5 class="description-header">Member_id</h5>
                      <span class="description-text"><?php echo $position; ?></span>
                      <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->

      </div><!-- /.container-fluid -->
    </section>





    <!-- Main content -->
    <section class="content">


    <div class="modal fade" id="atmodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Dues payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
             
            <form method="post" id='dues_form'>

            <input hidden type="text" class='form-control tfid' value='<?php echo $_GET['idd'] ?>'>
            <input hidden type="text" class='form-control tfname' value='<?php echo $_GET['memb'] ?>'>
              <div class='row'>

              <div class='col-6'>
                <div class='form-group'>
                  <label>Year</label>
                  <select name="year" class='form-control tfyear'>
                    <option value="<?php echo  date('Y')?>"><?php echo  date('Y')?></option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                  </select>
                </div>
              </div>

              <div class='col-6'>
                <div class='form-group'>
                  <label>Month</label>
                  <select name="month" class='form-control tfmonth'>
                    <option value="<?php echo  date('F')?>"><?php echo  date('F')?></option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
              </div>

              <div class='col-12'>
                <div class='form-group'>
                  <label>Amount(¢)</label>
                  <input type="text" class='form-control tfamount' name='amount' placeholder='0.00' style='text-align:center'>
                </div>
              </div>

              </div>
           
             
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success btconfirm">Confirm</button>
            </div>

            
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div> 
      <!-- /.modal -->

      <!-- Default box -->
    <div class="row" >

       <!-- Delete profile modal -->
       <div class="modal fade" id="mdquestion" style="margin-top: 15%;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="width: 100%; text-align: center;">Are you Sure Want to Delete<i class="fa fa-question"></i></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                 <div class='row'>
                                  <div class='col-4'>
                                  <input hidden  type="text" class='form-control tfid'>
                                  </div>
                                  <div class='col-4'>
                                  <input hidden  type="text" class='form-control tfmonth' >
                                  </div>
                                
                                  <div class='col-4'>
                                  <input hidden type="text" class='form-control tfyear' >
                                  </div>
                                 </div>
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


  <div class="col-12">
  <div class="card">
    <div class="card-body">
      <div>
        <a href="youth_dues_statistics.php?&mid=<?php echo $_GET['idd'] ?>&&memb=<?php echo $_GET['memb'] ?>" class='btn btn-primary btn-sm'> <i class='fa fa-line-chart'></i> Statistics</a>
        <a href="#" class='btn btn-primary btn-sm' style='float:right;' data-toggle='modal' data-target='#atmodal' > <i class='fa fa-plus'></i> Make Payment</a>
      </div>
      <br>
      <br>
<table class="table table-hover " table id="example1">
    <thead>
      <tr style="text-align:center">
      <th>ID</th>
      <th>Name</th>
      <th>Year</th>
      <th>Month</th>
      <th>Amount(¢)</th>
      <th>Status</th>
     <th></th>
      </tr>
    </thead>

   <tbody>
   
   
   <?php

             $mem_id = $_GET['idd'];
                  $sql = "SELECT * FROM dues WHERE member_id='$mem_id' AND department='Youth' ORDER BY year DESC ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                     
                      $member_id = $row['member_id'];
                     $name = $row['fullname'];
                     $year = $row['year'];
                     $month = $row['month'];
                     $amount = $row['amount'];
                     $status = $row['status'];
                     $date_created = $row['date_created'];

                  ?>

                  <tr style='text-align:center;'>
                  <td><?php echo $member_id ?></td>
                  <td><?php echo $name ?></td>
                  <td><?php echo $year ?></td>
                  <td><?php echo $month ?></td>
                 
                  <td>¢<?php echo number_format($amount,2); ?></td>
                  
                  <?php 
                  if($status === "Paid"){
                    echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> Paid </td>";
                 
                  }else{
                    echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> Unpaid </td>";
                  }
                  
                  ?>
                 <td>  
                 
                 <a  class="btn btn-default dropdown-toggle" data-toggle="dropdown"></a>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item btdel" data-toggle='modal' data-target='#mdquestion' href="#">Delete</a>
                    </div>
                    </td>

                </tr>
                 
                 <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
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
<script src="validate_youth_dues.js"></script>

</body>
</html>
