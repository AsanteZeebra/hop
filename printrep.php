<?php
include_once ('database_connection.php');




include_once('load_session.php');
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monthly Report</title>
  <?php include_once ('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
   <?php include_once('navbar.php'); ?>
    <!-- /.navbar -->
    <?php include_once ('sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
             
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <!-- Report Header -->
        <div style="text-align: center; margin-bottom: 30px;">
          <img src="dist/img/hop1.png" alt="Company Logo" style="width: 200px; height: 200px;">
          <h2 style="margin-top: 10px; margin-bottom: 5px;">Expense Report</h2>
          <h4><b>For: <?php echo htmlspecialchars($_POST['mnt']); ?> <?php echo htmlspecialchars($_POST['yr']); ?></b></h4>
        </div>

        <!-- Expense Table -->
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
          <thead style="background-color: #f4f4f4;">
            <tr>
              <th>#ID</th>
              <th>Category</th>
              <th>Amount (USD)</th>
              <th>Expense Type</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Secure user input
            $month = mysqli_real_escape_string($con, $_POST['mnt']);
            $year = mysqli_real_escape_string($con, $_POST['yr']);

            // Fetch data from database
            $sql = "SELECT transaction_id, category, SUM(amount) AS mt, expense_type, date 
                    FROM exepenses 
                    WHERE month='$month' AND year='$year' AND status='Approved' 
                    GROUP BY category";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['transaction_id']) . "</td>
                        <td>" . htmlspecialchars($row['category']) . "</td>
                        <td>" . number_format($row['mt'], 2) . "</td>
                        <td>" . htmlspecialchars($row['expense_type']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='5' style='text-align: center;'>No Records Found</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <!-- Summary Section -->
        <div style="margin-top: 30px;">
          <h3>Summary</h3>
          <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <tbody>
              <?php
              // Calculate income
              $sql = "SELECT SUM(amount) AS icom 
                      FROM exepenses 
                      WHERE expense_type='Income' AND month='$month' AND year='$year' AND status='Approved'";
              $result = mysqli_query($con, $sql);
              $income = $result && mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)['icom'] : 0;

              // Calculate expenditure
              $sql = "SELECT SUM(amount) AS ex 
                      FROM exepenses 
                      WHERE expense_type='Expenditure' AND month='$month' AND year='$year' AND status='Approved'";
              $result = mysqli_query($con, $sql);
              $expenditure = $result && mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)['ex'] : 0;

              // Calculate balance
              $balance = $income - $expenditure;

              echo "<tr>
                      <td><b>Income:</b> " . number_format($income, 2) . "</td>
                      <td><b>Expenditure:</b> " . number_format($expenditure, 2) . "</td>
                      <td><b>Balance:</b> " . number_format($balance, 2) . "</td>
                    </tr>";
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include_once ('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->



  <?php include_once ("script.php"); ?>


</body>

</html>