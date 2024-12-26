<?php 

include_once('load_session.php');


include_once('database_connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Attendance Records</title>
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
  <?php include_once('youth_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
       <!-- /.col -->
<div class="col-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
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
                  $sql = "SELECT COUNT(*) as total FROM attendance WHERE status='Present' and member_id='$mem_id' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
                      <h5 class="description-header"><?php echo $total ?> out of 52/3(weeks)</h5>
                      <span class="description-text">Presents</span>
                      
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
                  $sql = "SELECT COUNT(*) as total FROM attendance WHERE status='Absent' and member_id='$mem_id' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                      $total = $row['total'];
                  ?>
                      <h5 class="description-header"><?php echo $total; ?> out of 53/3(weeks)</h5>
                      <span class="description-text">Absents</span>
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
                              <form method="POST">
                                    <div class="modal-body">
                                 <div class='row'>
                                  <div class='col-3'>
                                  <input hidden type="text" class='form-control tfd'>
                                  </div>
                                  <div class='col-3'>
                                  <input hidden type="text" class='form-control tfm' >
                                  </div>
                                
                                  <div class='col-3'>
                                  <input hidden type="text" class='form-control tfy' >
                                  </div>
                                    <div class='col-3'>
                                  <input hidden type="text" class='form-control tfw' >
                                  </div>
                                  
                                 </div>
                                    <center>
                                        <button class="btn btn-info" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-danger delbtn">Yes</button>
                                    </center>
                                   
                                </div>
                              </form>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

    <div class="modal fade" id="atmodal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> Mark Attendance</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
             
            <form method="post" id='atform'>

            <input hidden type="text" name='idd' class='form-control tfid' value='<?php echo $_GET['idd'] ?>'>
            <input hidden type="text" name='nnm' class='form-control tfname' value='<?php echo $_GET['fname'] ?>'>
              <div class='row'>

              <div class='col-4'>
                <div class='form-group'>
                  <label>Year</label>
                  <select name="year"  class='form-control tfyear'>
                    <option value="<?php $w = date('Y'); echo $w; ?>"><?php $w = date('Y'); echo $w; ?></option>
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

              <div class='col-4'>
                <div class='form-group'>
                  <label>Month</label>
                  <select name="month" class='form-control tfmonth'>
                    <option value="<?php $w = date('F'); echo $w; ?>"><?php $w = date('F'); echo $w; ?></option>
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
             
              
              <div class='col-4'>
                <div class='form-group'>
                <label>Week</label>
                  <select name="week" class='form-control tfweek'>
                    <option value="<?php $w = date('W'); $fw="week$w"; echo $fw; ?>"><?php $w = date('W'); $fw="week$w"; echo $fw; ?> </option>
                  <option value='week1'>week1</option>
                  <option value="week2">week2</option>
                  <option value="week3">week3</option>
                  <option value="week4">week4</option>
                  <option value="week5">week5</option>
                  <option value="week6">week6</option>
                  <option value="week7">week7</option>
                  <option value="week8">week8</option>
                  <option value="week9">week9</option>
                  <option value="week10">week10</option>
                  <option value="week11">week11</option>
                  <option value="week12">week12</option>
                  <option value="week13">week13</option>
                  <option value="week14">week14</option>
                  <option value="week15">week15</option>
                  <option value="week16">week16</option>
                  <option value="week17">week17</option>
                  <option value="week18">week18</option>
                  <option value="week19">week19</option>
                  <option value="week20">week20</option>
                  <option value="week21">week21</option>
                  <option value="week22">week22</option>
                  <option value="week23">week23</option>
                  <option value="week24">week24</option>
                  <option value="week25">week25</option>
                  <option value="week26">week26</option>
                  <option value="week27">week27</option>
                  <option value="week28">week28</option>
                  <option value="week29">week29</option>
                  <option value="week30">week30</option>
                  <option value="week31">week31</option>
                  <option value="week31">week32</option>
                  <option value="week32">week33</option>
                  <option value="week33">week34</option>
                  <option value="week34">week35</option>
                  <option value="week35">week36</option>
                  <option value="week36">week37</option>
                  <option value="week37">week38</option>
                  <option value="week38">week39</option>
                  <option value="week39">week40</option>
                  <option value="week40">week41</option>
                  <option value="week42">week42</option>
                  <option value="week43">week43</option>
                  <option value="week44">week44</option>
                  <option value="week45">week45</option>
                  <option value="week46">week46</option>
                  <option value="week47">week47</option>
                  <option value="week48">week48</option>
                  <option value="week49">week49</option>
                  <option value="week50">week50</option>
                  <option value="week51">week51</option>
                  <option value="week52">week52</option>
                
        
                  </select>
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

    
  <div class="col-12">
  <div class="card">
    <div class="card-body">
      <div style='float:right;'><a href="#"  data-toggle='modal' data-target='#atmodal' class='btn btn-primary btn-sm'><i class='fa fa-plus'></i> Mark Attendance</a></div>
       <div style='float:left;'><a href="yatcard.php?idd=<?php echo $_GET['idd'] ?>" class='btn btn-primary btn-sm'><i class="fa-solid fa-expand"></i> Expand </a></div>
      <br>
      <br>
<table class="table table-hover " table id="example1">
    <thead>
      <tr style="text-align:center">
      <th>ID</th>
      <th>Name</th>
      <th>Year</th>
      <th>Month</th>
      <th>Week</th>
      <th hidden>Date_created</th>
      <th>Status</th>
      <th></th>
     
      </tr>
    </thead>

   <tbody>
   
   
   <?php

             $mem_id = $_GET['idd'];
                  $sql = "SELECT * FROM attendance WHERE member_id='$mem_id' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {

                     
                      $member_id = $row['member_id'];
                     $name = $row['fullname'];
                     $year = $row['year'];
                     $month = $row['month'];
                     $week = $row['week'];
                     $status = $row['status'];
                     $date_created = $row['date_created'];

                  ?>

                  <tr style='text-align:center;'>
                  <td><?php echo $member_id ?></td>
                  <td><?php echo $name ?></td>
                  <td><?php echo $year ?></td>
                  <td><?php echo $month ?></td>
                  <td><?php echo $week ?></td>
                  <td hidden><?php echo $date_created; ?></td>
                  <?php 
                  if($status === "Present"){
                    echo "<td><i class='fa-regular fa-circle-check' style='color:green'></i> Present </td>";
                 
                  }else{
                    echo "<td> <i class='fa-regular fa-circle-xmark' style='color:red'></i> Absent</td>";
                  }
                  
                  ?>
                 <td><a href="#" data-toggle="modal" data-target="#mdquestion" class='ll'><i class='fa fa-trash' style="color:red"></i></a></td>
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

<?php include_once("attendance.php"); ?>

</body>
</html>
