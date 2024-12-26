
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
  <title>Expenses | Report </title>
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
          
        <table border="1" style="width:20%">
            <tr style='text-align:center'>
                
                <td row="2" style="background-color:#343A40; color:white;"><h3>TOTAL</h3></td>
               
            </tr>
              <tr style="text-align:center">
                    <?php
                 
                  
                 
                  
            $cat = $_GET['cat'];
        
                  $sql = "SELECT SUM(amount) as mm FROM  exepenses ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                   $amount = $row['mm']
           
                  ?>
                <td><h3><?php echo number_format($amount,2); ?></h3></td>
                  <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
            </tr>
        </table>
        
    
      </div><!-- /.container-fluid -->
     
    </section>

     <!-- Main content -->
     <section class="content">
      
          <table class='table' >
           <thead>
            <tr>
              <th>#Transaction ID</th>
              <th>Category</th>
              <th>Amount(¢)</th>
              <th>Beneficiary</th>
            
              <th>Status</th>
                <th>Date Created</th>
             
            </tr>
           </thead>
         
          <tbody>
          <?php
                  
                  
                   
            $cat = $_GET['cat'];

            echo $cat;
        
                $sql = "SELECT * FROM `exepenses`";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      $id = $row['transaction_id'];
                      $category = $row['category'];
                      $amount = $row['amount'];
                      $date_created = $row['date_created'];
                      $details= $row['details'];
                      $status = $row['status'];
                      $benefit = $row['beneficiary'];
                     
           
                  ?>
            <tr>
           
        <td><?php echo $id ?></td>
        <td><?php echo $category ?></td>
       <td> <?php echo number_format($amount,2) ?></td>
       <td><?php echo $benefit ?></td>
       
        <?php if($status === "Pending"){
                        echo ' <td>  <span class="right badge badge-warning">Pending for Approval</span> </td>';
                    }else if($status === "Approved"){
                        echo  ' <td>  <span class="right badge badge-success">Approved</span> </td>';
                    }else{
                        echo ' <td>  <span class="right badge badge-danger">Rejected</span> </td>';
                    }
                    ?>
       <td> <?php echo $date_created ?></td>
      
      
      
            </tr>
            <?php   
            }
                  } else {
                    echo "No Records Found";
                  } ?>
          </tbody>
          <tfoot>
             <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
          </tfoot>
          </table>
                    

           
        
     
            <table style='width:25%; margin-left:70%; margin-buttom:10%' class="table">
           
             <tr>
                 <td style="text-align:right;"><b>Approved:</b></td>
                  <?php
                  
                  
                 
                  
            $cat = $_GET['cat'];
        
                  $sql = "SELECT SUM(amount) as am FROM  exepenses WHERE unique_reference='$cat' AND status='Approved' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    
                      $amount = $row['am'];
                     
                
                  ?>
                <td style="text-align:left; ">  <?php echo number_format($amount,2); ?></td>
                  <?php   
            }
                  } else {
                    echo "No Records Found";
                  } ?>
                
            </tr>
            
            <tr>
                <td style="text-align:right;"><b>Pending: </b></td>
               <?php
                  
                  
                 
                  
            $cat = $_GET['cat'];
        
                  $sql = "SELECT SUM(amount) as am FROM  exepenses WHERE unique_reference='$cat' AND status='Pending' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    
                      $amount = $row['am'];
                     
                
                  ?>
                <td><?php echo number_format($amount,2); ?></td>
                  <?php   
            }
                  } else {
                    echo "No Records Found";
                  } ?>
            </tr>
            
           
            <tr>
                <td style="text-align:right;"><b>Rejected: </b></td>
               <?php
                  
                  
                 
                  
            $cat = $_GET['cat'];
        
                  $sql = "SELECT SUM(amount) as am FROM  exepenses WHERE unique_reference='$cat' AND status='Rejected' ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                    
                      $amount = $row['am'];
                     
                
                  ?>
                <td style="text-align:left;"><?php echo number_format($amount,2); ?></td>
                  <?php   
            }
                  } else {
                    echo "No Records Found";
                  } ?>
            </tr>
        </table>
        <br>
        <br>
     
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


</body>
</html>
