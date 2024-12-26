<?php 
include_once('database_connection.php');


include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welfare List</title>
  <?php include_once('head.php'); ?>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar_general.php'); ?>
  <!-- /.navbar -->
  <?php include_once('general_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Welfare</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Welfare</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Back Button -->
    <button class="btn btn-primary btn-sm back" style="margin-left:10px;">
        <i class="fa fa-arrow-left"></i> Back
    </button>
    <br><br>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Members Table -->
                        <table class="table table-hover" id="example1">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Telephone</th>
                                    <th>Marital Status</th>
                                    <th>Age</th>
                                    <th>Occupation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM members";
                                $result = mysqli_query($con, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['id'];
                                        $member_id = $row['member_id'];
                                        $fullname = $row['fullname'];
                                        $telephone = $row['telephone'];
                                        $residence_address = $row['residense_address'];
                                        $status = $row['status'];
                                        $marital = $row['marital_status'];
                                        $occupation = $row['occupation'];
                                        $age = $row['age'];
                                ?>
                                    <tr class="text-center">
                                        <td><a href="#"><?php echo htmlspecialchars($member_id); ?></a></td>
                                        <td><?php echo htmlspecialchars($fullname); ?></td>
                                        <td><?php echo htmlspecialchars($telephone); ?></td>
                                        <td><?php echo htmlspecialchars($marital); ?></td>
                                        <td><?php echo htmlspecialchars($age); ?></td>
                                        <td><?php echo htmlspecialchars($occupation); ?></td>
                                        <td>
                                            <?php
                                            switch ($status) {
                                                case "Active":
                                                    echo "<label class='badge badge-success' data-toggle='tooltip' title='Member is Active'>" . htmlspecialchars($status) . "</label>";
                                                    break;
                                                case "Pending":
                                                    echo "<label class='badge badge-warning' data-toggle='tooltip' title='Member is Pending'>" . htmlspecialchars($status) . "</label>";
                                                    break;
                                                default:
                                                    echo "<label class='badge badge-danger' data-toggle='tooltip' title='Error'>Error</label>";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Payment Statistics Button -->
                                            <a href="payment_statistics.php?member_id=<?php echo $member_id; ?> && mid=<?php echo $_GET['mid']; ?> & name=<?php echo $fullname ?> & dept=Main" data-toggle="tooltip" 
                                               class="btn btn-info btn-sm" 
                                               data-toggle="tooltip" 
                                               title="View Payment Statistics">
                                                <i class="fa fa-bar-chart"></i> Payment Stats
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center text-danger'>No records found!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End of Members Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
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
