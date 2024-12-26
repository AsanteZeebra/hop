
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

              <form action="printrep.php?mid=<?php echo $_GET['mid']; ?>" method="post">

              <div class="row">
             
              <select name="mnt" class="form-control" style="width:10%">
                <option value="">Month</option>
                <?php
                    include_once ('database_connection.php');

                    $sql = "SELECT month from exepenses GROUP BY month";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                      while ($row = mysqli_fetch_array($result)) {
                       

                        ?>
                <option value="<?php echo $row['month'] ?>"><?php echo $row['month'] ?></option>
                <?php
                      }
                    } else {
                      echo "No records found";
                    }

                    ?>

               </select>  
               
               <select name="yr" class="form-control" style="width:10%">
                <option value="">Year</option>
                <?php
                    include_once ('database_connection.php');

                    $sql = "SELECT year from exepenses GROUP BY year";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                      while ($row = mysqli_fetch_array($result)) {
                       

                        ?>
                <option value="<?php echo $row['year'] ?>"><?php echo $row['year'] ?></option>
                <?php
                      }
                    } else {
                      echo "No records found";
                    }

                    ?>

               </select>

               <button type="submit" class="btn btn-primary" style="margin-left: 10px;"><i class="fa fa-print"></i>Preview</button>
              </div>
              </form>
                <table class="table table-hover" id="example3">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>

                      <th>Beneficiary</th>
                      <th>Date</th>
                      <th>Amount(¢)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include_once ('database_connection.php');

                    $sql = "SELECT * from  exepenses WHERE status='Approved' ORDER BY date_created DESC";
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
                          <td><?php echo $id; ?></td>
                          <td><?php echo $category; ?></td>
                          <td><?php echo $benefit; ?></td>
                          <td><?php echo $date; ?></td>
                          <td><?php echo number_format($amount,2); ?></td>
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