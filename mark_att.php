<?php
include_once('database_connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Session timeout handling
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3600) {
    session_unset(); // unset $_SESSION variable
    session_destroy(); // destroy session data in storage
    header("Location: index.php"); // redirect to login page
    exit;
}
$_SESSION['last_activity'] = time(); // update last activity time stamp

// Database queries with prepared statements
$maleQuery = $con->prepare("SELECT COUNT(*) AS numbers FROM members WHERE gender = ?");
$maleQuery->bind_param("s", $gender);
$gender = 'Male';
$maleQuery->execute();
$maleResult = $maleQuery->get_result();
$maleCount = $maleResult->fetch_assoc();

$femaleQuery = $con->prepare("SELECT COUNT(*) AS numbers FROM members WHERE gender = ?");
$femaleQuery->bind_param("s", $gender);
$gender = 'Female';
$femaleQuery->execute();
$femaleResult = $femaleQuery->get_result();
$femaleCount = $femaleResult->fetch_assoc();

$totalQuery = $con->prepare("SELECT COUNT(*) AS numbers FROM members");
$totalQuery->execute();
$totalResult = $totalQuery->get_result();
$totalCount = $totalResult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOP | Members List </title>
    <?php include_once('head.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Male: <?php echo number_format($maleCount['numbers']); ?></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Female: <?php echo number_format($femaleCount['numbers']); ?></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <b style="padding-right:20px">Total: <?php echo number_format($totalCount['numbers']); ?></b>
            </ul>
        </nav>
        <?php include_once('att_sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Mark Attendance</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                                <li class="breadcrumb-item active">mark_attendance</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-hover" id="example1">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th><i class="fa fa-image"></i></th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Telephone</th>
                                            <th>Marital Status</th>
                                            <th>Occupation</th>
                                            <th><i class="fa-solid fa-bars"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $con->prepare("SELECT * FROM members ORDER BY member_id DESC");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $photo = !empty($row['file_name']) ? 'uploads/' . htmlspecialchars($row['file_name']) : 'dist/img/user.png';
                                            ?>
                                            <tr style="text-align:center">
                                                <td><img src="<?php echo $photo; ?>" alt="img" style="width:50px; height: 50px;"><br><small><?php echo htmlspecialchars($row['age']); ?> Years</small></td>
                                                <td><a href="att_records.php?mid=<?php echo $_GET['mid'] ?>&uid=<?php echo htmlspecialchars($row['member_id']);  ?>&&fname=<?php echo htmlspecialchars($row['fullname']); ?>"><?php echo htmlspecialchars($row['member_id']); ?></a></td>
                                                <td><?php echo htmlspecialchars($row['fullname']); ?> </td>
                                                <td><?php echo htmlspecialchars($row['telephone']); ?></td>
                                                <td><?php echo htmlspecialchars($row['marital_status']); ?> <br><small><?php echo htmlspecialchars($row['number_of_children']); ?> child/ren</small></td>
                                                <td><?php echo htmlspecialchars($row['occupation']); ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-success btn-sm btt" data-toggle="modal" data-target="#modal-default" data-toggle='tooltip' data-placement='top' title='Mark Attendance'><i class="fa-solid fa-user-check"></i></a>
                                                   <a href="att_records.php?mid=<?php echo $_GET['mid'] ?>&uid=<?php echo htmlspecialchars($row['member_id']);  ?>&&fname=<?php echo htmlspecialchars($row['fullname']); ?>" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Attendance Records"><i class="fa fa-chart-line"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <!-- Modal Structure -->
<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attendanceModalLabel">Mark Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="acform">
          <div class="form-group">
            <label for="student-name">Name</label>
            <input type="text" class="form-control tfname" name="fullname" placeholder="Enter name" readonly>
        </div>

        <div class="form-group">
            <label for="student-name">Member_ID</label>
            <input type="text" class="form-control tfid" name="member_id"  placeholder="ID" readonly>
        </div>

          <div class="form-group">
            <label for="attendance-status">Status</label>
            <select class="form-control tfstatus" name="status">
                <option value="">--Select status--</option>
              <option>Present</option>
              <option>Absent</option>
              <option>Late</option>
            </select>
          </div>


          <div class="form-group">
            <label for="attendance-comments ">Comments</label>
            <textarea class="form-control tfnote" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary bts" style="width:100%">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include_once('footer.php'); ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <?php include_once("script.php"); ?>
<script src="mark_att.js"></script>



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
