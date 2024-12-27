<?php
// Include necessary files
include_once('database_connection.php');
include_once('load_session.php');

// Sanitize GET parameters to prevent SQL injection
$department = isset($_GET['dept']) ? mysqli_real_escape_string($con, $_GET['dept']) : null;
if (!$department) {
    die("Error: Department not specified.");
}

// Include navbar based on department
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
        die("Error: Invalid department specified.");
}

// Include sidebar based on department
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
        die("Error: Invalid department specified.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youth Reports</title>
    <?php include_once('head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar and Sidebar are already included above -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            // Sanitize POST inputs
                            $from = isset($_POST['from']) ? mysqli_real_escape_string($con, $_POST['from']) : null;
                            $to = isset($_POST['to']) ? mysqli_real_escape_string($con, $_POST['to']) : null;
                            $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : null;
                                   
                            $department = $_GET['dept'];
                            if ($from && $to && $status) {
                                echo "<h4>$status Dues From: " . date('Y-M-jS', strtotime($from)) . " To: " . date('Y-M-jS', strtotime($to)) . "</h4>";

                                $sql = "
                                    SELECT month, year, status, SUM(amount) AS total, COUNT(month) AS payments
                                    FROM dues
                                    WHERE date_created BETWEEN '$from' AND '$to' 
                                      AND status = '$status'
                                      AND department = '$department'
                                    GROUP BY month, year
                                ";
                                $result = mysqli_query($con, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    echo '<table class="table table-hover">';
                                    echo '<thead>
                                            <tr style="text-align: center;">
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Status</th>
                                                <th>Payment Count</th>
                                                <th>Amount(¢)</th>
                                            </tr>
                                          </thead>';
                                    echo '<tbody>';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr style="text-align: center;">';
                                        echo "<td>{$row['month']}</td>";
                                        echo "<td>{$row['year']}</td>";
                                        echo $row['status'] === "Paid" ? 
                                             "<td><span class='badge badge-success'>Paid</span></td>" : 
                                             "<td><span class='badge badge-danger'>Unpaid</span></td>";
                                        echo "<td>{$row['payments']}</td>";
                                        echo "<td><b>" . number_format($row['total'], 2) . "</b></td>";
                                        echo '</tr>';
                                    }
                                    echo '</tbody></table>';
                                } else {
                                    echo "<div class='alert alert-warning'>No records found for the selected criteria.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Invalid input. Please provide valid dates and status.</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include_once('footer.php'); ?>
</div>

<?php include_once("script.php"); ?>
</body>
</html>
