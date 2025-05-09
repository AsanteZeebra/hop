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
                            <h1>Rejected Expenses</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">rejected_expenses</li>
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


                                <!-- Delete profile modal -->
                                <div class="modal fade" id="mdquestion" style="margin-top: 15%;">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="width: 100%; text-align: center;">Are you
                                                    Sure Want to Delete<i class="fa fa-question"></i></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class='row'>
                                                        <div class='col-4' hidden>
                                                            <input type="text" class='form-control ddt'>
                                                        </div>


                                                    </div>
                                                    <center>
                                                        <button type="button" class="btn btn-info"
                                                            data-dismiss="modal">No</button>
                                                        <button type="button" class="btn btn-danger dbt">Yes</button>
                                                    </center>
                                                </form>

                                            </div>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->



                                <table class='table table-hover' id="example1">

                                    <thead>
                                        <tr>

                                            <th>#ID</th>
                                            <th>Category</th>
                                            <th>Expense_type</th>
                                            <th>Benefitiary</th>
                                            <th style='text-align:center'>Amount(¢)</th>
                                            <th>Status</th>
                                            <th>Date</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $department = $_GET['dept'];

                                        $sql = "SELECT * FROM  exepenses WHERE status='Rejected' AND department='$department' ORDER BY id DESC ";
                                        $result = mysqli_query($con, $sql);
                                        if ($result) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $id = $row['transaction_id'];
                                                $category = $row['category'];
                                                $amount = $row['amount'];
                                                $iid = $row['id'];
                                                $date = $row['date'];
                                                $benefit = $row['beneficiary'];
                                                $reference = $row['unique_reference'];
                                                $status = $row['status'];
                                                $expensetype = $row['expense_type'];

                                                ?>
                                                <tr>

                                                    <td><a href="#" class='text-muted'> <?php echo $id ?></a></td>
                                                    <td><?php echo $category ?></td>

                                                    <?php
                                                    if ($expensetype === "Income") {
                                                        echo " <td><label for='' class='badge badge-success'>$expensetype <i class='fa-solid fa-arrow-down'></i></label></td>";
                                                    } else if ($expensetype === "Expenditure") {
                                                        echo " <td><label for='' class='badge badge-warning'>$expensetype <i class='fa-solid fa-arrow-up'></i></label></td>";
                                                    }
                                                    ?>
                                                    <td><?php echo $benefit ?></td>

                                                    <td style='text-align:center'>¢<?php echo number_format($amount, 2) ?></td>

                                                    <?php if ($status === "Pending") {
                                                        echo ' <td>  <span class="right badge badge-warning">Pending</span> </td>';
                                                    } else if ($status === "Approved") {
                                                        echo ' <td>  <span class="right badge badge-success">Approved</span> </td>';
                                                    } else {
                                                        echo ' <td>  <span class="right badge badge-danger">Rejected</span> </td>';
                                                    }
                                                    ?>
                                                    <td><?php echo $date ?></td>


                                                <?php }
                                        } else {
                                            echo "No Records Found";
                                        } ?>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>

                                            <td><b>Total:</b>
                                                <hr>
                                            </td>
                                            <?php
                                            $department = $_GET['dept'];

                                            $sql = "SELECT sum(amount) as amount FROM exepenses WHERE status='Rejected' AND department='$department'";
                                            $result = mysqli_query($con, $sql);
                                            if ($result) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    $mn = $row['amount'];


                                                    ?>
                                                    <td style="text-align:center"><b>¢<?php echo number_format($mn, 2) ?> </b>
                                                        <hr>
                                                    </td>
                                                <?php }
                                            } else {
                                                echo "No Records Found";
                                            } ?>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>

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