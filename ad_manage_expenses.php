<?php
include_once('database_connection.php');

include_once('load_session.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Expenses</title>
    <?php include_once('head.php'); ?>

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
                            <h1>Manage Expenses</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">manage_expenses</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i>
                Back</button>
            <br>
            <br>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="modal fade" id="sm" tabindex="-1" role="dialog"
                                    aria-labelledby="decisionModal" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="decisionModal">Decision</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <input type="text" class="form-control tf6" hidden>
                                                    <table class="table">
                                                        <tr>
                                                            <td class="td1"></td>
                                                            <td class="td2"></td>
                                                            <td class="td3"></td>
                                                            <td class="td4"><b></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <textarea disabled id="decisionDetails" rows="5"
                                                                    class="form-control td5"
                                                                    aria-label="Decision details"></textarea>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btr"
                                                        aria-label="Decline Decision">Decline</button>
                                                    <button type="submit" class="btn btn-success btt"
                                                        aria-label="Approve Decision">Approve</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.modal -->

                                <!-- Delete profile modal -->
                                <div class="modal fade" id="mdquestion" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteConfirmModal" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center w-100" id="deleteConfirmModal">
                                                    Are you sure you want to delete? <i class="fa fa-question"></i>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <div class="form-group d-none">
                                                        <input type="text" class="form-control ddt" aria-hidden="true">
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal"
                                                            aria-label="Cancel delete">
                                                            No
                                                        </button>
                                                        <button type="submit" class="btn btn-danger dbt"
                                                            aria-label="Confirm delete">
                                                            Yes
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.modal -->
                                <div class="modal fade" id="md" tabindex="-1" role="dialog"
                                    aria-labelledby="pendingExpensesModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 id="pendingExpensesModal">Pending Expenses</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#REF</th>
                                                            <th>Category</th>
                                                            <th>Beneficiary</th>
                                                            <th>Amount</th>
                                                            <th>Decision</th>
                                                            <th>Department</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (isset($_GET['dept'])) {
                                                            $department = htmlspecialchars($_GET['dept']);

                                                            // Use prepared statements
                                                            $stmt = $con->prepare("SELECT * FROM exepenses WHERE department = ? AND status='Pending' ORDER BY date_created DESC");
                                                            $stmt->bind_param("s", $department);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = htmlspecialchars($row['transaction_id']);
                                                                    $category = htmlspecialchars($row['category']);
                                                                    $amount = htmlspecialchars(number_format($row['amount'], 2));
                                                                    $date = htmlspecialchars($row['date']);
                                                                    $benefit = htmlspecialchars($row['beneficiary']);
                                                                    $reference = htmlspecialchars($row['transaction_id']);
                                                                    $status = htmlspecialchars($row['status']);
                                                                    $details = htmlspecialchars($row['details']);
                                                                    $department = htmlspecialchars($row['department']);

                                                                    // Display row
                                                                    echo "<tr>
                                        <td>{$reference}</td>
                                        <td>{$category}</td>
                                        <td>{$benefit}</td>
                                        <td>{$amount}</td>
                                        <td><a href='' data-toggle='modal' data-dismiss='modal' data-target='#sm' class='tdedit'>{$status}</a></td>
                                        <td><label class='badge badge-info'>" . getDepartmentLabel($department) . "</label></td>
                                    </tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='6' class='text-center'>No Records Found</td></tr>";
                                                            }

                                                            $stmt->close();
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Helper function to get department labels
                                function getDepartmentLabel($department)
                                {
                                    $labels = [
                                        'Men' => 'Men\'s Department',
                                        'Women' => 'Women\'s Department',
                                        'Youth' => 'Youth Department',
                                        'Main' => 'General Welfare',
                                        'Children' => 'Children\'s Department',
                                    ];
                                    return $labels[$department] ?? 'Unknown Department';
                                }
                                ?>



                                <!-- /.modal -->

                                <!-- Approved-->
                                <div class="modal fade" id="md1" tabindex="-1" role="dialog"
                                    aria-labelledby="approvedExpensesModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 id="approvedExpensesModal">Approved Expenses</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#REF</th>
                                                            <th>Category</th>
                                                            <th>Beneficiary</th>
                                                            <th>Amount</th>
                                                            <th>Decision</th>
                                                            <th>Department</th>
                                                            <th>Date Created</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (isset($_GET['dept'])) {
                                                            $department = htmlspecialchars($_GET['dept']);

                                                            // Use prepared statement
                                                            $stmt = $con->prepare("SELECT * FROM exepenses WHERE status = 'Approved' AND department = ? ORDER BY id DESC");
                                                            $stmt->bind_param("s", $department);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();

                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $reference = htmlspecialchars($row['transaction_id']);
                                                                    $category = htmlspecialchars($row['category']);
                                                                    $beneficiary = htmlspecialchars($row['beneficiary']);
                                                                    $amount = number_format($row['amount'], 2);
                                                                    $status = htmlspecialchars($row['status']);
                                                                    $department = htmlspecialchars($row['department']);
                                                                    $dateCreated = htmlspecialchars($row['date']);
                                                                    $details = htmlspecialchars($row['details']);

                                                                    // Get department label
                                                                    $departmentLabel = getDepartmentLabe($department);

                                                                    echo "
                                        <tr>
                                            <td>{$reference}</td>
                                            <td>{$category}</td>
                                            <td>{$beneficiary}</td>
                                            <td>{$amount}</td>
                                            <td>{$status}</td>
                                            <td><span class='badge badge-info'>{$departmentLabel}</span></td>
                                            <td>{$dateCreated}</td>
                                        </tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='7' class='text-center'>No Records Found</td></tr>";
                                                            }

                                                            $stmt->close();
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Reusable function for department labels
                                function getDepartmentLabe($department)
                                {
                                    $labels = [
                                        'Men' => 'Men\'s Department',
                                        'Women' => 'Women\'s Department',
                                        'Youth' => 'Youth Department',
                                        'Main' => 'General Welfare',
                                        'Children' => 'Children\'s Department',
                                    ];
                                    return $labels[$department] ?? 'Unknown Department';
                                }
                                ?>


                                <table class="table table-hover" id="example1">
                                    <thead>
                                        <tr>
                                            <th hidden>IID</th>
                                            <th>#ID</th>
                                            <th>Category</th>
                                            <th>Expense Type</th>
                                            <th>Beneficiary</th>
                                            <th style="text-align:center;">Amount (¢)</th>
                                            <th>Status</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['dept'])) {
                                            $department = htmlspecialchars($_GET['dept']);

                                            // Use prepared statements
                                            $stmt = $con->prepare("SELECT * FROM exepenses WHERE department = ? ORDER BY id DESC");
                                            $stmt->bind_param("s", $department);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $iid = htmlspecialchars($row['id']);
                                                    $transactionId = htmlspecialchars($row['transaction_id']);
                                                    $category = htmlspecialchars($row['category']);
                                                    $expenseType = htmlspecialchars($row['expense_type']);
                                                    $beneficiary = htmlspecialchars($row['beneficiary']);
                                                    $amount = number_format($row['amount'], 2);
                                                    $status = htmlspecialchars($row['status']);
                                                    $department = htmlspecialchars($row['department']);
                                                    $date = htmlspecialchars($row['date']);

                                                    echo "<tr>
                        <td hidden>{$iid}</td>
                        <td>{$transactionId}</td>
                        <td>{$category}</td>
                        <td>" . getExpenseTypeBadge($expenseType) . "</td>
                        <td>{$beneficiary}</td>
                        <td style='text-align:center;'>¢{$amount}</td>
                        <td>" . getStatusBadge($status) . "</td>
                        <td>" . getDepartmentBadge($department) . "</td>
                        <td>{$date}</td>
                        <td style='text-align:center;'>
                            <a href='#' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#md'>
                                <i class='fa-regular fa-pen-to-square'></i>
                            </a>
                            <a href='#' class='btn btn-danger btn-sm btdel' data-toggle='modal' data-target='#mdquestion'>
                                <i class='fa-regular fa-trash-can'></i>
                            </a>
                        </td>
                    </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='10' class='text-center'>No Records Found</td></tr>";
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        $stmt = $con->prepare("SELECT SUM(amount) AS totalAmount FROM exepenses WHERE department = ? AND status='Approved' AND expense_type='Income'");
                                        $stmt->bind_param("s", $department);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $totalAmount = number_format($row['totalAmount'] ?? 0, 2);

                                        echo "<tr>
            <td colspan='4'><b>Total:</b></td>
            <td style='text-align:center;'><b>¢{$totalAmount}</b></td>
            <td colspan='5'></td>
        </tr>";

                                        $stmt->close();
                                        ?>
                                    </tfoot>
                                </table>

                                <?php
                                // Reusable functions for labels
                                function getExpenseTypeBadge($type)
                                {
                                    if ($type === "Income") {
                                        return "<span class='badge badge-success'>Income <i class='fa-solid fa-arrow-down'></i></span>";
                                    } elseif ($type === "Expenditure") {
                                        return "<span class='badge badge-warning'>Expenditure <i class='fa-solid fa-arrow-up'></i></span>";
                                    }
                                    return "<span class='badge badge-secondary'>Unknown</span>";
                                }

                                function getStatusBadge($status)
                                {
                                    $badges = [
                                        "Pending" => "badge-warning",
                                        "Approved" => "badge-success",
                                        "Rejected" => "badge-danger",
                                    ];
                                    $class = $badges[$status] ?? "badge-secondary";
                                    return "<span class='badge {$class}'>{$status}</span>";
                                }

                                function getDepartmentBadge($department)
                                {
                                    $departments = [
                                        "Men" => "Men's Department",
                                        "Women" => "Women's Department",
                                        "Youth" => "Youth Department",
                                        "Main" => "General Welfare",
                                        "Children" => "Children's Department",
                                    ];
                                    $label = $departments[$department] ?? "Unknown Department";
                                    return "<span class='badge badge-info'>{$label}</span>";
                                }
                                ?>


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
    <?php include_once("expenses_manager.php"); ?>
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