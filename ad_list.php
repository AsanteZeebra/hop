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
            include_once('navbar.php');
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
         include_once('sidebar.php');
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
                 
       echo     $department= $_GET['dept']; 
            
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
            <th>Telephone</th>
            <th>Marital Status</th>
            <th>Age</th>
            <th>Occupation</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
   echo  $department = $_GET['dept'];
            $query = "
                SELECT 
                    *
                FROM members 
                WHERE department = ? 
                ORDER BY id DESC";

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
                        $id = $row['id'];
                        $member_id = $row['member_id'];
                        $fullname = $row['fullname'];
                        $telephone = $row['telephone'];
                        $marital = $row['marital_status'];
                        $age = $row['age'];
                        $occupation = $row['occupation'];
                        $status = $row['status'];

                       

                        $idd = $_GET['mid'];

                        // Render table row
                        echo "
                        <tr class='text-center'>
                            <td><a href='ad_member_profile.php?mid=$idd &dept=$department && uid=$member_id' class='text-primary font-weight-bold'>$member_id</a></td>
                            <td>$fullname</td>
                            <td>$telephone</td>
                            <td>$marital</td>
                            <td>$age</td>
                            <td>$occupation</td>
                            <td>";
                        if ($status === "Active") {
                            echo "<span class='badge badge-success' data-toggle='tooltip' title='This member is active'>$status</span>";
                        } elseif ($status === "Pending") {
                            echo "<span class='badge badge-warning' data-toggle='tooltip' title='Membership is pending'>$status</span>";
                        } else {
                            echo "<span class='badge badge-danger' data-toggle='tooltip' title='Unrecognized status'>$status</span>";
                        }
                        echo "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center text-muted'>No records found</td></tr>";
                }

                // Close the statement
                $stmt->close();
            } else {
                error_log("Database Error: " . $con->error);
                echo "<tr><td colspan='7' class='text-center text-danger'>An error occurred. Please try again later.</td></tr>";
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
