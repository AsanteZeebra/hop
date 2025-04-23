<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Statement</title>

    <?php include_once("head.php") ?>

</head>

<body>
    <?php include_once('database_connection.php'); ?>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4" style="background-color: #212529; padding: 20px; border-radius: 5px;">
        <?php
        $mem_id = $_GET['mid'];
        $sql = "SELECT * FROM members WHERE member_id='$mem_id'";
        $run = mysqli_query($con, $sql);
        if ($run) {
          while ($row = mysqli_fetch_assoc($run)) {
           
            ?>
        <h2 style="color: white;"><?php echo $row['fullname'] ?></h2>
        <?php
            }
        } else {
            echo "<tr><td colspan='2'>No records found</td></tr>";
        }
        ?>

<?php 
    $dep = $_GET['dept'];
    switch ($dep) {
        case 'Main':    
       echo "<h5 style='color:rgb(179, 179, 179);'>General Welfare</h5>";
            break;
        case 'Men':
            echo "<h5 style='color:rgb(179, 179, 179);'>Men's Welfare</h5>";
            break;
            case 'Women':
                echo "<h5 style='color:rgb(179, 179, 179);'>Women's Welfare</h5>";
                break;
            case 'Youth':
                echo "<h5 style='color:rgb(179, 179, 179);'>Youth Welfare</h5>";
                break;
        default:
         echo "department not found";
            break;
    }
    
    
    ?>
           
            <p style="color:rgb(179, 179, 179);">Generated on: <?php echo date('F d, Y'); ?></p>
        </div>




        <!-- Customer Details Section -->
        <div class="" style="width: 40%; margin: auto; float: left;">
            <table class="table ">
                <tbody>
                <?php
        $mem_id = $_GET['mid'];
        $sql = "SELECT * FROM members WHERE member_id='$mem_id'";
        $run = mysqli_query($con, $sql);
        if ($run) {
          while ($row = mysqli_fetch_assoc($run)) {
           
            ?>

                    <tr>
                        <th style="text-align: right;">Member Name:</th>
                        <td><?php echo $row['fullname'] ?></td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Member_ID:</th>
                        <td><?php echo $row['member_id'] ?></td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Telephone:</th>
                        <td><?php echo $row['telephone'] ?></td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Branch:</th>
                        <td>
                            Tema
                        </td>
                    </tr>
                    <?php
            }
        } else {
            echo "<tr><td colspan='2'>No records found</td></tr>";
        }
        ?>
                </tbody>
            </table>
        </div>

        <!-- Customer Details Section -->
        <div class="" style="width: 30%; margin: auto; float: right;">
            <table class="table table-bordered">
                <tbody>
                <?php
        $department = $_GET['dept'];
        $mem_id = $_GET['mid'];
        $sql = "SELECT 
                    SUM(CASE WHEN status = 'Paid' THEN amount ELSE 0 END) AS paid,
                    SUM(CASE WHEN status = 'Unpaid' THEN amount ELSE 0 END) AS unpaid
                FROM dues
                WHERE department = '$department' AND member_id='$mem_id' ";
        $run = mysqli_query($con, $sql);
        if ($run) {
            while ($row = mysqli_fetch_assoc($run)) {
                ?>
                    <tr>
                        <th style="text-align: right;">Total Paid(¢)</th>
                        <td><?php echo number_format($row['paid'], 2); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">Total Unpaid(¢)</th>
                        <td><?php echo number_format($row['unpaid'], 2); ?></td>
                    </tr>
                    <?php
            }
        } else {
            echo "<tr><td colspan='2'>No records found</td></tr>";
        }
        ?>
                    <tr>

                        <th style="text-align: right;">Benefit Request</th>
                        
                        <?php
        $mem_id = $_GET['mid'];
        $sql = "SELECT COUNT(*) AS tt FROM benefits WHERE member_id='$mem_id'";
        $run = mysqli_query($con, $sql);
        if ($run) {
          while ($row = mysqli_fetch_assoc($run)) {
           
            ?>
                        <td>
                           <?php $row['tt'] ?>
                        </td>
                        <?php
            }
        } else {
            echo "<tr><td colspan='2'>No records found</td></tr>";
        }
        ?>
                    </tr>
                    
                </tbody>
            </table>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table ">
                <thead class="thead-dark">
                    <tr>

                        <th>Transaction ID</th>
                        <th>Month_year</th>
                        <th>Date</th>

                        <th>Amount (¢)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $department = $_GET['dept'];
                    $mid = $_GET['mid'];
                    $sql = "SELECT * FROM dues WHERE member_id= '$mid' AND department='$department' ORDER BY year DESC ";
                    $run = mysqli_query($con, $sql);
                    if ($run) {
                        while ($row = mysqli_fetch_assoc($run)) {
                            $statusBadge = $row['status'] === "Paid"
                                ? "<span class='badge badge-success'>Paid</span>"
                                : "<span class='badge badge-danger'>Unpaid</span>";
                            echo "<tr>
            <td>{$row['member_id']}</td>
            <td>{$row['month']}_{$row['year']}</td>
             <td>{$row['date_created']}</td>
            <td>¢" . number_format($row['amount'], 2) . "</td>

            <td>$statusBadge</td>
          </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="text-center mt-4">
            <p class="text-muted">This statement is auto-generated and does not require a signature.</p>
        </div>
    </div>

    <?php include_once("script.php") ?>

    <script>
    window.onload = function() {
        window.print();
    };
   </script>

</body>

</html>