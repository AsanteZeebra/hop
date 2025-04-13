<?php 
include_once('database_connection.php');


include_once('load_session.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> List</title>
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
        case 'Main':
            include_once('navbar_general.php');
          break;
    case 'Youth':
        include_once('navbar_youth.php');
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
        case 'Main':
         include_once('general_sidebar.php');
          break;
    case 'Women':
        include_once('womens_sidebar.php');
        break;
        case 'Youth':
        include_once('youth_sidebar.php');
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
             
          

            <h1>
                <?php
            
            
            $department = $_GET['dept']; 
            
            switch ($department) {
                case 'Men':
                   echo "Men's list";
                    break;
                case 'Women':
                   echo "Women's list";
                    break;
                    case 'Youth':
                        echo "Youth's list";
                    break;
                default:
                   
                    break;
            }
            
            ?> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">list</a></li>
              <li class="breadcrumb-item active"><?php 
                 
            $department= $_GET['dept']; 
            
            switch ($department) {
                case 'Men':
                   echo "mens_list";
                    break;
                case 'Women':
                   echo "womens_list";
                    break;
                    case 'Youth':
                        echo "youth_list";
                    break;
                default:
                   
                    break;
            }
              
              ?>
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" >

  <div class="col-12">
  <div class="card">
    <div class="card-body">
    <table class="table table-hover" id="example1">
    <thead class="thead-dark">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Total Amount(¢)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $department = $_GET['dept'] ?? '';

        // Prepare the SQL query
        $query = "            
            SELECT 
                id,
                member_id, 
                fullname, 
                department,
                SUM(amount) AS total
            FROM 
                dues
            WHERE 
                department = ?
            GROUP BY 
                member_id
            ORDER BY 
                id DESC";

        if ($stmt = $con->prepare($query)) {
            // Bind parameters
            $stmt->bind_param("s", $department);

            // Execute the statement
            $stmt->execute();

            // Fetch results
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Sanitize output values to prevent XSS
                    $id = htmlspecialchars($row['id']);
                    $member_id = htmlspecialchars($row['member_id']);
                    $fullname = htmlspecialchars($row['fullname']);
                    $department_safe = htmlspecialchars($row['department']);
                    $amount = htmlspecialchars($row['total']);
                    $idd = $_GET['mid'];

                    // Determine badge class based on amount
                    $badgeClass = $amount == 0 ? 'badge-danger' : 'badge-success';
                    $badgeText = $amount == 0 ? 'No Amount' : 'Paid';
                    $amountFormatted = number_format($amount, 2);

                    // Render table row
                    echo "
                    <tr class='text-center'>
                        <td><a href='dues_records.php?mid=$idd&dept=$department_safe&idd=$member_id' class='text-primary font-weight-bold'>$member_id</a></td>
                        <td>$fullname</td>
                        <td>$department_safe</td>
                        <td><span class='badge $badgeClass'>$amountFormatted</span> </td>
                        <td>
                            <a href='dues_records.php?mid=$idd&dept=$department_safe&idd=$member_id ' class='btn btn-outline-primary btn-sm' data-toggle='tooltip' title='Dues Records'><i class='fas fa-arrow-right'></i> View</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center text-muted'>No records found</td></tr>";
            }

            // Close the statement
            $stmt->close();
        } else {
            error_log("Database Error: " . $con->error);
            echo "<tr><td colspan='5' class='text-center text-danger'>An error occurred. Please try again later.</td></tr>";
        }
        ?>
    </tbody>
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
  
  $('.back').click(function(){
    if (document.referrer) {
      window.location.href = document.referrer;
  } else {
      window.history.back();
  }

  });

</script>
</body>
</html>
