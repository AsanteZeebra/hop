<?php
include_once('database_connection.php');


include_once('load_session.php');
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benefit Claim Confirmation</title>
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
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
   <div class="wrapper">
   
  
  <!-- /.navbar -->


  <!-- Sidebar -->

<div class="header-section">
        <img src="dist/img/hop1.png" alt="Logo" style="height: 30%;">
        <h4>Benefit Claim Confirmation</h4>
        <p>{{church_address}}</p>
    </div>
    
    <table class="info-table" width="100%">
        <tr>
            <th>Member Name:</th>
            <td>{{fullname}}</td>
            <th>Member ID:</th>
            <td>{{member_id}}</td>
        </tr>
        <tr>
            <th>Benefit Type:</th>
            <td>{{benefit_type}}</td>
            <th>Amount:</th>
            <td>${{amount}}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{status}}</td>
            <th>Approved By:</th>
            <td>{{approved_by}}</td>
        </tr>
    </table>
    
    <h5 class="mt-4">Details</h5>
    <table class="table-section">
        <tr>
            <th>Date Submitted</th>
            <td>{{date_submitted}}</td>
            <th>Reference ID</th>
            <td>{{reference_id}}</td>
        </tr>
        <tr>
            <th>Comments</th>
            <td colspan="3">{{comments}}</td>
        </tr>
    </table>
    
    <div class="footer-section">
        <p><strong>Note:</strong> If you have any questions, please contact the church administration.</p>
        <p class="text-muted">This document is strictly confidential and intended for authorized use only.</p>
    </div>
    </div>
    <?php include_once('footer.php'); ?>
    <?php include_once('script.php'); ?>
</body>
</html>
