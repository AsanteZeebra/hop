
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Statement</title>
   
   <?php include_once("head.php") ?>

</head>
<body>
<?php  include_once('database_connection.php'); ?>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4" style="background-color: #212529; padding: 20px; border-radius: 5px;">
            <h2 style="color: white;">Samuel Obeng</h2>
            <h5 style="color:rgb(179, 179, 179);">General Welfare</h5>
            <p style="color:rgb(179, 179, 179);">Generated on <?php echo date('F d, Y'); ?></p>
        </div>




         <!-- Customer Details Section -->
         <div class="" style="width: 40%; margin: auto; float: left;">
            <table class="table ">
                <tbody>
                    <tr>
                        <th style="text-align: right;">Member Name:</th>
                        <td>John Doe Mensah Yaw Baah</td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Member_ID:</th>
                        <td>123456789</td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Telephone:</th>
                        <td>0125489878</td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Branch:</th>
                        <td>
                           Tema
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Customer Details Section -->
        <div class="" style="width: 30%; margin: auto; float: right;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="text-align: right;">Total Paid(¢)</th>
                        <td>1,220.00</td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Total Unpaid(¢)</th>
                        <td>200.00</td> <!-- Replace with dynamic data -->
                    </tr>
                    <tr>
                        <th style="text-align: right;">Benefit Request</th>
                        <td>
                           5 times 
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">Years</th>
                        <td>
                           5years
                        </td>
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
$sql = "SELECT * FROM dues WHERE member_id= '$mid' AND department='$department' ";
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
            <td>" . number_format($row['amount'], 2) . "</td>

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

</body>
</html>