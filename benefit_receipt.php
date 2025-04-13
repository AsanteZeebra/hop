<?php
include_once('database_connection.php');
include_once('load_session.php');

// Sanitize input
$department = htmlspecialchars($_GET['dept']);
$transaction_id = htmlspecialchars($_GET['mid']);

// Prepare and execute query
$stmt = $con->prepare("SELECT * FROM benefits WHERE transaction_id = ?");
$stmt->bind_param("s",  $transaction_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benefits</title>
    <?php include_once('head.php'); ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-section img {
            max-height: 80px;
        }
        .info-table th, .info-table td {
            padding: 8px;
            border-bottom: 1px solid #000;
        }
        .info-table th {
            text-align: left;
            font-weight: bold;
        }
        .table-section {
            border-collapse: collapse;
            width: 100%;
        }
        .table-section th, .table-section td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .table-section th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer-section {
            margin-top: 20px;
            font-size: 14px;
            border-top: 1px solid black;
            padding-top: 10px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
   <div class="wrapper">
       <div class="header-section">
           <img src="dist/img/hop1.png" alt="Church Logo" />
           <h4 style="font-size:30px">Benefits Form</h4>
           <p> Tema Branch</p>
       </div>
         <table  style="float: right;">
            <tr>
                <td><img src="dist/img/user.png" alt="photo" style="width: 10%; float:right"></td>
            </tr>
         </table>
       <table class="info-table" width="100%">
       <?php
       if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
       ?>
           <tr>
               <th>Member Name:</th>
               <td><?php echo $row['fullname']; ?></td>
               <th>Member ID:</th>
               <td><?php echo $row['member_id']; ?></td>
           </tr>
           <tr>
               <th>Benefit Type:</th>
               <td><?php echo $row['benefit_type']; ?></td>
               <th>Amount(¢):</th>
               <td><?php echo number_format($row['amount'],2)?></td>
           </tr>
           <tr>
               <th>Status:</th>
               <td><?php echo $row['status']; ?></td>
               <th>Approved By:</th>
               <td></td>
           </tr>
      
       </table>

       <h5 class="mt-4">Details</h5>
       <table class="table-section">
           <tr>
               <th>Date Created</th>
               <td><?php echo $row['created_at'] ?? 'N/A'; ?></td>
               <th>Total Amount(¢)</th>
               <td><?php echo number_format($row['amount'],2) ?? 'N/A'; ?></td>
           </tr>
           <tr>
               <th>Comments</th>
               <td colspan="3"><?php echo $row['comment'] ?? 'N/A'; ?></td>
           </tr>
       </table>
       <?php
           }
       } else {
           echo "<tr><td colspan='4'>No Record Found!</td></tr>";
       }
       ?>
       <div class="footer-section">
           <p><strong>Note:</strong> If you have any questions, please contact the church administration.</p>
           <p class="text-muted">This document is strictly confidential and intended for authorized use only.</p>
       </div>
   </div>
   <?php include_once('footer.php'); ?>
   <?php include_once('script.php'); ?>

   <script>
    window.onload = function() {
        window.print();
    };
   </script>
</body>
</html>