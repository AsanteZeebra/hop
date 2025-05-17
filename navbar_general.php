<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     

    <li class="nav-item">
    <?php
                    $sql = "SELECT SUM(amount) AS total FROM exepenses WHERE department='Main' AND expense_type='Income' AND status='Approved' ";
                    $execute = mysqli_query($con, $sql);
                    if ($execute) {
                      while ($row = mysqli_fetch_array($execute)) {

                        $count = $row['total'];
                        ?>
      <b class="nav-link">Expenses Balance(¢): <?php echo number_format($count,2)?></b>
      <?php }
                    } else {
                      echo "No Records Found";
                    } ?>
      
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="new_member.php?dept=<?php echo $_GET['dept']; ?>">
        <i class="fa-solid fa-circle-plus"></i> New
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="welfare_summary_report.php?dept=<?php echo $_GET['dept'] ?>" role="button">
          <i class="fas fa-print"></i>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      
      



        <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link"  href="signout.php" role="button" style="color:red">
        <i class="fa-solid fa-arrow-right-from-bracket" style="color:red"></i> logout
        </a>
      </li>
    </ul>
  </nav>

  