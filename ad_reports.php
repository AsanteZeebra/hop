<?php include_once('database_connection.php');


include_once('load_session.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Womens Reports</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">



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
            case 'Main':
                include_once('navbar.php');
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
            case 'Main':
                include_once('sidebar.php');
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
            <h1>  Welfare Reports <?php echo date('Y') ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   
    <!-- Main content -->
    <section class="content">

    <div class="row">
    <!-- Paid Dues Chart -->
    <div class="col-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Welfare Statistics <?php echo date('Y'); ?> <i class='fa fa-line-chart'></i></h3>
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
                <div class="chart">
                    <?php
                    $year = date('Y');
                    $department = $_GET['dept'] ?? '';

                    // Ensure input is sanitized and validated
                    if (!empty($department)) {
                        $stmt = $con->prepare("
                            SELECT COUNT(amount) AS ct, month AS st 
                            FROM dues 
                            WHERE status = ? AND year = ? AND department = ? 
                            GROUP BY month
                        ");
                        $status = 'Paid';
                        $stmt->bind_param("sis", $status, $year, $department);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $stt = [];
                        $ctt = [];
                        while ($row = $result->fetch_assoc()) {
                            $stt[] = $row['st'];
                            $ctt[] = $row['ct'];
                        }
                    } else {
                        echo "<p>No data available. Please select a department.</p>";
                    }
                    ?>
                    <canvas id="bar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Unpaid Dues Chart -->
    <div class="col-6">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Unpaid Welfare Statistics <?php echo date('Y'); ?> <i class='fa fa-line-chart'></i></h3>
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
                <div class="chart">
                    <?php
                    if (!empty($department)) {
                        $stmt = $con->prepare("
                            SELECT COUNT(amount) AS ct, month AS st 
                            FROM dues 
                            WHERE status = ? AND year = ? AND department = ? 
                            GROUP BY month
                        ");
                        $status = 'Unpaid';
                        $stmt->bind_param("sis", $status, $year, $department);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $s = [];
                        $c = [];
                        while ($row = $result->fetch_assoc()) {
                            $s[] = $row['st'];
                            $c[] = $row['ct'];
                        }
                    } else {
                        echo "<p>No data available. Please select a department.</p>";
                    }
                    ?>
                    <canvas id="dot" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Default box -->
      <div class="row">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Welfare from Date to Date <i class='fa fa-calendar'></i></h3>
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
                <!-- Form for Filtering Data -->
                <form action="preview.php" method="post">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="from">From:</label>
                                <input type="date" class="form-control" name="from" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="to">To:</label>
                                <input type="date" class="form-control" name="to" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" class="form-control" required>
                                    <option value="" disabled selected>-Select-</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Fetch</button>
                        </div>
                    </div>
                </form>

                <!-- Data Table -->
                <table class="table table-hover" id="example4">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Amount (¢)</th>
                            <th>Date Created</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Sanitize and validate input
                        $department = $_GET['dept'] ?? '';

                        if (!empty($department)) {
                            $stmt = $con->prepare("SELECT * FROM dues WHERE department = ?");
                            $stmt->bind_param("s", $department);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $member_id = $row['member_id'];
                                    $member_name = $row['fullname'];
                                    $month = $row['month'];
                                    $year = $row['year'];
                                    $amount = $row['amount'];
                                    $status = $row['status'];
                                    $date_created = $row['date_created'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($member_id); ?></td>
                                        <td><?php echo htmlspecialchars($member_name); ?></td>
                                        <td><?php echo htmlspecialchars($month); ?></td>
                                        <td><?php echo htmlspecialchars($year); ?></td>
                                        <td><?php echo number_format($amount, 2); ?></td>
                                        <td><?php echo htmlspecialchars($date_created); ?></td>
                                        <td>
                                            <span class="badge <?php echo $status === 'Paid' ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo htmlspecialchars($status); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No records found.</td></tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">Please select a department.</td></tr>';
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

<?php include_once('youth_chart.php'); ?>
</body>
</html>
