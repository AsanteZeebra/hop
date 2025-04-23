<?php

include_once('database_connection.php');


include_once('load_session.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welfare</title>
  <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
     
    <?php 
$department = $_GET['dept'];
    switch ($department) {
        case 'Main':
            include_once('navbar_general.php');
            break;
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
        echo "Unknown department";
            break;
    };
    
    ?> 
    
    <!-- /.navbar -->

    <!-- Sidebar -->
    <?php 
    $department = $_GET['dept'];
    switch ($department) {
        case 'Main':
            include_once('general_sidebar.php'); 
            break;
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
          echo "Unknown department";
            break;
    }
    
   
    
     ?>

<!-- /Sidebar -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><?php echo $_GET['dept']; ?> Welfare(¢)</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">welfare</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <button class="btn btn-primary btn-sm back" style="margin-left:10px">
  <i class="fa fa-arrow-left"></i> Back
</button>
<br><br>

<!-- Main content -->
<section class="content">

  <!-- Payment Modal -->
  <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" id="paymentForm">
            <div class="form-group">
              <label for="paymentAmount">Payment Amount (¢)</label>
              <input type="text" id="paymentAmount" class="form-control text-center" placeholder="Enter amount" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="paymentForm">Confirm Payment</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Payment Summary -->
<div class="row">
    
  <div class="col-6 ">
  
  <?php
    
    $stmt = $con->prepare("
    SELECT 
        (COUNT(CASE WHEN amount > 0 THEN 1 END) / COUNT(*)) * 100 AS paid_percentage
    FROM 
        dues 
    WHERE 
        department = ?
    ");
    $stmt->bind_param('s', $department);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
     $paid = number_format( $row['paid_percentage'],2); 
    
    // echo "Paid: " . $paid;
    
     

     echo "  <h2 style='margin-left:40%'>$paid%</h2>";
    }
        ?>
  </div>



  <div class="col-6 ">



<?php
   $department = $_GET['dept'];
   $query = "
   SELECT 
       (COUNT(CASE WHEN amount = 0 THEN 1 END) / COUNT(*)) * 100 AS unpaid_percentage
   FROM 
       dues WHERE department = '$department'
";
$run = mysqli_query($con, $query);

if ($run) {
   while ($row = mysqli_fetch_array($run)) {
 $unpaid=   number_format( $row['unpaid_percentage'],2);
       echo "  <h2 style='margin-left:40%'>$unpaid%</h2>";
     
   }
}



   ?>
  </div>

</div>


  <div class="row">
    <!-- Paid Contributors -->
  

    <div class="col-md-6">
   
      

      <div class="card shadow-sm ">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0">Top Contributors</h5>
        </div>
        <div class="card-body overflow-auto" style="max-height: 500px;">
          <table class="table table-striped table-hover">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Months</th>
                <th>Amount (¢)</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $department = $_GET['dept'];
              $sql = "SELECT COUNT(month) AS mnts, SUM(amount) AS amt, fullname, member_id, status FROM dues WHERE status ='Paid' AND department='$department' GROUP BY  member_id ORDER BY mnts DESC";
              $run = mysqli_query($con, $sql);
              if ($run) {
                while ($row = mysqli_fetch_assoc($run)) {
                  echo "<tr>
                          <td>{$row['member_id']}</td>
                          <td>{$row['fullname']}</td>
                          <td><span class='badge badge-warning'>{$row['mnts']} month/s</span></td>
                          <td>" . number_format($row['amt'], 2) . "</td>
                          <td><span class='badge badge-success'>Paid</span></td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Top Debtors -->
    <div class="col-md-6">

   
      <div class="card shadow-sm ">
        <div class="card-header bg-danger text-white">
          <h5 class="card-title mb-0">Top Debtors</h5>
        </div>
        <div class="card-body overflow-auto" style="max-height: 500px;">
          <table class="table table-striped table-hover">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Months</th>
                <th>Amount (¢)</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $department = $_GET['dept'];
              $sql = "SELECT COUNT(month) AS mnts, SUM(amount) AS amt, fullname, member_id, status FROM dues WHERE status ='Unpaid' AND department='$department' GROUP BY member_id ORDER BY mnts DESC  ";
              $run = mysqli_query($con, $sql);
              if ($run) {
                while ($row = mysqli_fetch_assoc($run)) {
                  echo "<tr>
                          <td>{$row['member_id']}</td>
                          <td>{$row['fullname']}</td>
                          <td><span class='badge badge-danger'>{$row['mnts']} month/s</span></td>
                          <td>" . number_format($row['amt'], 2) . "</td>
                          <td><span class='badge badge-danger'>Unpaid</span></td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Payment Records -->
  <div class="card mt-4 shadow-sm">
    <div class="card-header bg-secondary text-white">
      <h5 class="card-title mb-0">Unpaid Dues List</h5>
    </div>
    <div class="card-body">
      <table class="table table-striped table-hover" id="example1">
        <thead class="thead-light">
          <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Month</th>
            <th>Amount (¢)</th>
            <th>Billed On</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $department = $_GET['dept'];
          $sql = "SELECT * FROM dues WHERE department='$department' AND status='Unpaid' GROUP BY member_id ORDER BY year DESC";
          $result = mysqli_query($con, $sql);
          if ($result) {
            while ($row = mysqli_fetch_array($result)) {
              echo "<tr>
                      <td><a href='dues_records.php?idd={$row['member_id']}&memb={$row['fullname']}&mid={$_GET['mid']}'>{$row['member_id']}</a></td>
                      <td>{$row['fullname']}</td>
                      <td>{$row['month']} {$row['year']}</td>
                      <td>" . number_format($row['amount'], 2) . "</td>
                      <td>{$row['date_created']}</td>
                      <td><span class='badge badge-danger'>Unpaid</span></td>
                      <td><a href='dues_records.php?idd={$row['member_id']}&memb={$row['fullname']}&mid={$_GET['mid']} &dept={$_GET['dept']}' class='btn btn-outline-primary btn-sm'><i class='fa fa-arrow-circle-right'></i> Pay</a> </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
          }
          ?>
        </tbody>
      </table>
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

    $('.back').click(function () {
      if (document.referrer) {
        window.location.href = document.referrer;
      } else {
        window.history.back();
      }

    });

  </script>

</body>

</html>