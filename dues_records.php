<?php 

include_once('database_connection.php');


include_once('load_session.php');

$department = $_GET['dept'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Individual Dues Records</title>
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
        echo "department not found";
        break;
}
    
   ?>
    <!-- /.navbar -->
    <?php 
    $dep = $_GET['dept'];
    switch ($dep) {
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
         echo "department not found";
            break;
    }
    
    
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
  <div class="container-fluid">
    <?php
$department = $_GET['dept'];
    $mem_id = $_GET['idd'];
    $sql = "SELECT COUNT(month) as month, fullname FROM dues WHERE member_id='$mem_id' AND status='Unpaid' AND department='$department'";
    $run = mysqli_query($con, $sql);
    if ($run) {
      while ($row = mysqli_fetch_assoc($run)) {
        $mname = $row['fullname'];
        $wk = $row['month'];

        if ($wk !== '0') {
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Notice!</strong> $mname has unpaid dues for the past $wk month/s.
                 
                </div>";
        }
      }
    } else {
      echo "<div class='alert alert-warning'>No records found.</div>";
    }
    ?>

    <button class="btn btn-primary btn-sm back my-3">
      <i class="fa fa-arrow-left"></i> Back
    </button>

    <div class="card card-widget widget-user">
      <div class="col-12">
        <?php
        $department = $_GET['dept'];
        $sql = "SELECT * FROM members WHERE member_id='$mem_id'";
        $run = mysqli_query($con, $sql);
        if ($run) {
          while ($row = mysqli_fetch_assoc($run)) {
            $member_name = $row['fullname'];
            $address = $row['residense_address'];
            $telephone = $row['telephone'];
            $status = $row['status'];
            $position = $row['member_id'];
            ?>

            <div class="widget-user-header bg-primary text-white">
              <h3 class="widget-user-username"> <?php echo $member_name; ?> </h3>
              <h5 class="widget-user-desc"> <?php echo $address; ?> </h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="dist/img/user.png" alt="User Avatar">
            </div>
            <div class="card-footer">
              <div class="row text-center">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"> <?php echo $telephone; ?> </h5>
                    <span class="description-text">Telephone</span>
                  </div>
                </div>
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Member Status</h5>
                    <span class="description-text"> <?php echo $status; ?> </span>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Member ID</h5>
                    <span class="description-text"> <?php echo $position; ?> </span>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<div class='alert alert-warning'>No records found.</div>";
        }
        ?>
      </div>
    </div>
  </div>
</section>






      <!-- Main content -->
      <section class="content">

<!-- Modal for Dues Payment -->
<div class="modal fade" id="atmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Dues Payment</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="dues_form">
                    <input type="" class="form-control tfid" value="<?php echo $_GET['idd']; ?>">
                    <input type="" class="form-control tfname" value="<?php echo $_GET['memb']; ?>">
                    <input type="" class="form-control tfdept" value="<?php echo $_GET['dept']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year</label>
                                <select name="year" class="form-control tfyear">
                                    <?php 
                                        $currentYear = date('Y');
                                        echo "<option value='{$currentYear}'>{$currentYear}</option>";
                                        for ($i = 2010; $i <= $currentYear; $i++) {
                                            echo "<option value='{$i}'>{$i}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Month</label>
                                <select name="month" class="form-control tfmonth">
                                    <?php
                                        $months = [
                                            'January', 'February', 'March', 'April', 'May', 
                                            'June', 'July', 'August', 'September', 'October', 
                                            'November', 'December'
                                        ];
                                        $currentMonth = date('F');
                                        echo "<option value='{$currentMonth}'>{$currentMonth}</option>";
                                        foreach ($months as $month) {
                                            echo "<option value='{$month}'>{$month}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Amount (¢)</label>
                                <input type="text" class="form-control tfamount text-center" name="amount" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btconfirm">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="mdquestion" style="margin-top: 15%;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100">Are you sure you want to delete? <i class="fa fa-question"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" class="form-control tfid">
                <input type="hidden" class="form-control tfmonth">
                <input type="hidden" class="form-control tfyear">
                <input type="hidden" class="form-control tfdep" value="<?php echo $_GET['dept']; ?>">
                <button class="btn btn-info" data-dismiss="modal">No</button>
                <button class="btn btn-danger delbtn">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Dues Payment History</h3>
                <a href="dues_statistics.php?idd=<?php echo $_GET['idd'] ?>&&memb=<?php echo $_GET['idd'] ?>&mid=<?php echo $_GET['mid'] ?>&dept=<?php echo $_GET['dept']; ?>" class="btn btn-warning btn-sm float-right">
                    <i class="fa fa-line-chart"></i> Statistics
                </a>
                <button class="btn btn-light btn-sm float-right mr-2" data-toggle="modal" data-target="#atmodal">
                    <i class="fa fa-plus"></i> Make Payment
                </button>
            </div>
            <div class="card-body">
                <table class="table  table-hover text-center" id="example1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Amount (¢)</th>
                            <th>Date Paid</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $department = $_GET['dept'];
                        $mem_id = $_GET['idd'];
                        $sql = "SELECT * FROM dues WHERE member_id='$mem_id' AND department='$department' ORDER BY year DESC";
                        $run = mysqli_query($con, $sql);

                        if ($run && mysqli_num_rows($run) > 0) {
                            while ($row = mysqli_fetch_assoc($run)) {
                                $statusBadge = $row['status'] === "Paid" 
                                    ? "<span class='badge badge-success'>Paid</span>" 
                                    : "<span class='badge badge-danger'>Unpaid</span>";
                                echo "
                                <tr>
                                    <td>{$row['member_id']}</td>
                                    <td>{$row['fullname']}</td>
                                    <td>{$row['year']}</td>
                                    <td>{$row['month']}</td>
                                    <td>¢" . number_format($row['amount'], 2) . "</td>
                                    <td>{$row['date_created']}</td>
                                    <td>{$statusBadge}</td>
                                   <td>
    <div class='btn-group'>
        <button class='btn btn-default' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='border: none; background: transparent;'>
            <i class='fa fa-ellipsis-v'></i>
        </button>
        <div class='dropdown-menu dropdown-menu-right'>
            <a class='dropdown-item btdel' data-toggle='modal' data-target='#mdquestion'>Delete</a>
        </div>
    </div>
</td>

                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No records found</td></tr>";
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
  <script src="validate_dues.js?t=12345"></script>

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