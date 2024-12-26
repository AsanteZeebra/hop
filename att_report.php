<?php

include_once('database_connection.php');



include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Report </title>
    <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once('att_navbar.php') ?>
        </nav>
        <!-- /.navbar -->
        <?php include_once('att_sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Attendance Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">attendance_report</li>
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
                    <div class="col-6">
                        <div class="card card-primary card-outline">
                            <h3 class="card-title"></h3>
                            <div class="card-body">
                                <h4 class="badge badge-primary">Present - Monthly</h4>

                                <div class="chart">

                                    <?php


                                    $year = date('Y');

                                    $query = $con->query("SELECT month AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Present' OR status='Late' AND gender='Male' GROUP BY month");

                                    foreach ($query as $row) {


                                        $sy[] = $row['ms'];

                                        $sam[] = $row['sam'];




                                    }
                                    ?>
                                    <?php


                                    $year = date('Y');

                                    $query = $con->query("SELECT month AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Present' OR status='Late' AND gender='Female' GROUP BY month");

                                    foreach ($query as $row) {




                                        $sam1[] = $row['sam'];




                                    }
                                    ?>
                                    <canvas id="dot" style="height: 220px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card card-danger card-outline">
                            <div class="card-body">
                                <h4 class="badge badge-danger">Absentees - Monthly</h4>
                            </div>

                            <div class="chart">

                                <?php


                                $year = date('Y');

                                $query = $con->query("SELECT month AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Absent' AND gender='Male' GROUP BY month");

                                foreach ($query as $row) {


                                    $ssy[] = $row['ms'];

                                    $ssam[] = $row['sam'];




                                }
                                ?>
                                <?php


                                $year = date('Y');

                                $query = $con->query("SELECT month AS ms, COUNT(*) AS sam FROM attendance  WHERE year='$year' AND status='Absent' AND gender='Female' GROUP BY month");

                                foreach ($query as $row) {




                                    $ssam1[] = $row['sam'];




                                }
                                ?>
                                <canvas id="dot1" style="height: 220px;"></canvas>
                            </div>

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card card-success card-outline">

                            <div class="card-body">
                                <h4 class="badge badge-success">Most Punctual</h4>
                                <!-- list -->
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card card-warning card-outline">
                            <div class="card-body">
                                <h4 class="badge badge-warning">Late Commers</h4>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Name</th>
                                                <th>Count</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
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
    <?php include_once("att_repchart.php"); ?>


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