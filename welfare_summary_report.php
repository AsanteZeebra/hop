<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>

    <?php include_once("head.php") ?>

</head>

<body>
    <?php include_once('database_connection.php'); ?>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4" style="background-color: #212529; padding: 20px; border-radius: 5px;">
            <h1 class="text-white">Welfare Summary Report</h1>
            <h3 class="text-white">Tema Branch</h3>
         

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
                   $today = date("Y-M-js");
                    $sql = "SELECT * FROM dues WHERE date_created= '$today' AND department='$department' ORDER BY year DESC ";
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
                <tfoot>

                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td colspan="2">
                            <?php
                            $department = $_GET['dept'];
                            $today = date("Y-M-js");
                            $sql = "SELECT SUM(amount) AS total_amount FROM dues WHERE date_created= '$today' AND department='$department'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo "¢" . number_format($row['total_amount'], 2);
                            ?>
                        </td>
                    </tr>
                </tfoot>
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