
<?php include_once ('database_connection.php'); 


include_once('load_session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Expenses Reports</title>
  <?php include_once ('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
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
              <h1>Expenses Reports</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      </section>
    <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">

          <div class="col-12">
            <div class="card">
            <div class="card-body">
  <!-- Form for Filtering Reports -->
  <form action="ad_printrep.php?mid=<?php echo htmlspecialchars($_GET['mid']); ?> &&dept=<?php echo $_GET['dept'] ?>" method="post">
    <div class="row mb-3">
      <!-- Month Dropdown -->
      <div class="col-md-3">
        <select name="mnt" class="form-control">
          <option value="">Select Month</option>
          <?php
          // Fetch distinct months
          $sql = "SELECT DISTINCT month FROM exepenses ORDER BY month";
          $result = mysqli_query($con, $sql);
          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . htmlspecialchars($row['month']) . '">' . htmlspecialchars($row['month']) . '</option>';
            }
          } else {
            echo '<option value="">No records found</option>';
          }
          ?>
        </select>
      </div>

      <!-- Year Dropdown -->
      <div class="col-md-3">
        <select name="yr" class="form-control">
          <option value="">Select Year</option>
          <?php
          // Fetch distinct years
          $sql = "SELECT DISTINCT year FROM exepenses ORDER BY year";
          $result = mysqli_query($con, $sql);
          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . htmlspecialchars($row['year']) . '">' . htmlspecialchars($row['year']) . '</option>';
            }
          } else {
            echo '<option value="">No records found</option>';
          }
          ?>
        </select>
      </div>

      <!-- Preview Button -->
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Preview</button>
      </div>
    </div>
  </form>

  <!-- Expense Records Table -->
  <table class="table table-hover" id="example3">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Beneficiary</th>
        <th>Date</th>
        <th>Amount (¢)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch all approved expenses
      $sql = "SELECT * FROM exepenses WHERE status='Approved' ORDER BY date_created DESC";
      $result = mysqli_query($con, $sql);
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr>
                  <td>' . htmlspecialchars($row['transaction_id']) . '</td>
                  <td>' . htmlspecialchars($row['category']) . '</td>
                  <td>' . htmlspecialchars($row['beneficiary']) . '</td>
                  <td>' . htmlspecialchars($row['date']) . '</td>
                  <td>' . number_format($row['amount'], 2) . '</td>
                </tr>';
        }
      } else {
        echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
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

    <?php include_once ('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->



  <?php include_once ("script.php"); ?>

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