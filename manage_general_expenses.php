
<?php 
  include_once('database_connection.php');


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
  <title>Manage Expenses</title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar_general.php'); ?>
  <?php include_once('general_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Expenses</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">manage_expenses</li>
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
        
         <div class="modal fade" id="sm">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Decision</h4>
              <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#md" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
           <form method="POST">
               <input type="text" class="form-control tf6" disabled hidden>
                  <table class="table">
                <tr>
                    <td class="td1"></td>
                    <td class="td2"></td>
                    <td class="td3"></td>
                    <td class="td4"><b></b></td>
                </tr>
                <tr>
                    <td colspan="5"><textarea disabled name="" id="" cols="100" rows="5" style="border:none" class="td5"> </textarea></td>
                  
                </tr>
                
            </table>
         
            
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger btr" >Decline</button>
              <button type="button" class="btn btn-success btt">Approve</button>
            </div>
              </form>
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
                                    <h5 class="modal-title" style="width: 100%; text-align: center;">Are you Sure Want to Delete<i class="fa fa-question"></i></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form method="post">
                                <div class='row' >
                                  <div class='col-4' hidden>
                                  <input  type="text" class='form-control ddt'>
                                  </div>
                                
                                
                                 </div>
                                    <center>
                                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-danger dbt">Yes</button>
                                    </center>
                                </form>
                                   
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
  
 
         <div class="modal fade" id="md">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4>Pending Expenses</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>#REF</th>
                          <th>Category</th>
                          <th>Beneficiary</th>
                          <th>Amount</th>
                          <th>Decision</th>
                           <th>Date_created</th>
                          <th hidden></th>
                      </tr>
                  </thead>
                  <tbody>
                       <?php
                
                  
                  $sql = "SELECT * from  exepenses WHERE status='Pending' AND department='Main' ORDER BY date_created DESC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['transaction_id'];
                      $category = $row['category'];
                      $amount = $row['amount'];
                    
                      $date = $row['date'];
                     $benefit = $row['beneficiary'];
                     $reference = $row['transaction_id'];
                     $status = $row['status'];
                     $details = $row['details'];
           
                  ?>
                      <tr>
                          <td><?php echo $reference ?></td>
                          <td><?php echo $category ?></td>
                          <td><?php echo $benefit ?></td>
                          <td><?php echo number_format($amount,2) ?></td>
                          <td><a href="" data-toggle="modal" data-dismiss="modal" data-target="#sm" class="tdedit"><?php echo $status ?></a> </td>
                           <td><?php echo $date ?></td>
                          <td hidden><p><?php echo $details; ?></p></td>
                      </tr>
                      
                       <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
                  </tbody>
              </table>
            </div>
          
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<!-- Approved-->
  <div class="modal fade" id="md1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4>Approved Expenses</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>#REF</th>
                          <th>Category</th>
                          <th>Beneficiary</th>
                          <th>Amount</th>
                          <th>Decision</th>
                            <th>Date_created</th>
                          <th hidden></th>
                      </tr>
                  </thead>
                  <tbody>
                       <?php
                 
                  $sql = "SELECT * from  exepenses WHERE status='Approved' AND department='Main' ORDER BY date_created DESC";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['transaction_id'];
                      $category = $row['category'];
                      $amount = $row['amount'];
                    
                      $date = $row['date'];
                     $benefit = $row['beneficiary'];
                     $reference = $row['transaction_id'];
                     $status = $row['status'];
                     $details = $row['details'];
           
                  ?>
                      <tr>
                          <td><?php echo $reference ?></td>
                          <td><?php echo $category ?></td>
                          <td><?php echo $benefit ?></td>
                          <td><?php echo number_format($amount,2) ?></td>
                          <td><?php echo $status ?> </td>
                            <td><?php echo $date ?></td>
                          <td hidden><p><?php echo $details; ?></p></td>
                      </tr>
                      
                       <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
                  </tbody>
              </table>
            </div>
          
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

       
    <table class='table table-hover' id="example1">
        
    <thead>
               <tr>
                <th hidden>IID</th>
                <th>#ID</th>
                <th>Category</th>0
                <th>Expenses_type</th>
                 <th>Benefitiary</th>
                <th style='text-align:center'>Amount(¢)</th>
                <th>Status</th>
                 <th>Date</th>
                <th></th>
               </tr>
            </thead>
            <tbody>
            <?php
                 
                  
                  $sql = "SELECT * FROM  exepenses WHERE department='Main' ORDER BY id DESC ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['transaction_id'];
                      $category = $row['category'];
                      $amount = $row['amount'];
                    $iid = $row['id'];
                      $date = $row['date'];
                     $benefit = $row['beneficiary'];
                     $reference = $row['unique_reference'];
                     $status = $row['status'];
                     $expensetype = $row['expense_type'];
           
                  ?>
                <tr>
                  <td hidden><?php echo $iid; ?></td>
                    <td> <?php echo $id ?></td>
                    <td><?php echo $category ?></td>
                    <?php 
                    if($expensetype === "Income"){
                      echo " <td><label for='' class='badge badge-success'>$expensetype <i class='fa-solid fa-arrow-down'></i></label></td> ";
                    }else if($expensetype === "Expenditure"){
                      echo " <td><label for='' class='badge badge-warning'> $expensetype <i class='fa-solid fa-arrow-up'></i></label></td> ";
                    }
                    ?>
                   
                    <td><?php echo $benefit ?></td>
                  
                    <td style='text-align:center'><label for="">¢<?php echo number_format($amount,2) ?></label></td>
                     
                    <?php if($status === "Pending"){
                        echo ' <td>  <span class="right badge badge-warning">Pending</span> </td>';
                    }else if($status === "Approved"){
                        echo  ' <td>  <span class="right badge badge-success">Approved</span> </td>';
                    }else{
                        echo ' <td>  <span class="right badge badge-danger">Rejected</span> </td>';
                    }
                    ?>

                    <td><?php echo $date ?></td>
                    
                   

                   <td>
                   <div class='btn-group'>
        <button class='btn btn-default' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='border: none; background: transparent;'>
            <i class='fa fa-ellipsis-v'></i>
        </button>
        <div class='dropdown-menu dropdown-menu-right'>
            <a class='dropdown-item btdel' data-toggle='modal' data-target='#mdquestion'><i class=" fa fa-trash-can"></i> Delete</a>
        </div>
    </div>
                   </td>
                    <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
                </tr> 
            </tbody>
            <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total:</b><hr></td>
               
                <?php
               
                  
                  $sql = "SELECT sum(amount) as amount FROM exepenses WHERE department='Main'";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                   
                      $mn = $row['amount'];
                    
           
                  ?>
                <td style="text-align:center"><b>¢<?php echo number_format($mn,2) ?> </b> <hr></td>
                <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
                <td></td>
                <td></td>
               
              </tr>
            </tfoot>
        
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
<script src="manage_general_expenses.js"></script>


</body>
</html>