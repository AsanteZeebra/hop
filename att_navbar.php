<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
       <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members WHERE gender='Male' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
        <a href="#" class="nav-link">Male: <?php echo number_format($numb) ?></a>
         <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
           <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members WHERE gender='Female' ";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
        <a href="#" class="nav-link">Female: <?php echo number_format($numb) ?></a>
         <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
         <?php
                  
                  $sql = "SELECT COUNT(*) AS numbers FROM members";
                  $run = mysqli_query($con, $sql);
                  if ($run) {
                    while ($row = mysqli_fetch_assoc($run)) {
                       
                       $numb = $row['numbers'];
                    
                  ?>
   <b style="padding-right:20px">Total: <?php echo number_format($numb) ?></b>
     <?php
                    }
                  } else {
                    echo "No records found";
                  }

                  ?>
    </ul>
  </nav>