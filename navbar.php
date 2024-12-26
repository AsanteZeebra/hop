
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

    
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">

          <a class="nav-link" data-toggle="dropdown" href="#">
            
          <i class="fa-solid fa-user-plus"></i>
            <?php
            $sql = "SELECT COUNT(*) AS total FROM members where status='Pending'";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $total = $row['total'];


                ?>
                <span class="badge badge-warning navbar-badge"><?php echo $total; ?></span>

              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?php echo $total; ?> Members without department</span>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>



            <?php
            $sql = "SELECT *  FROM members where status='Pending'";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $fullname = $row['fullname'];
                $status = $row['status'];
                $marital = $row['marital_status'];


                ?>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fa-solid fa-user mr-2"></i> <?php echo $fullname; ?> -
                  <small><?php echo $marital ?></small>
                  <span class="float-right text-muted text-sm"><i class="fa-regular fa-circle-dot" style="color:#FFC107"></i></span>
                </a>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>

            <div class="dropdown-divider"></div>
            <a href="floating_membership_list.php?mid=<?php echo $_GET['mid'] ?>" class="dropdown-item dropdown-footer">See All
              Notifications</a>
          </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            
            <i class="far fa-bell"></i>
            <?php
            $sql = "SELECT COUNT(*) AS total FROM reports";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $total = $row['total'];


                ?>
                <span class="badge badge-warning navbar-badge"><?php echo $total; ?></span>

              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?php echo $total; ?> Notifications</span>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>



            <?php
            $sql = "SELECT *  FROM reports";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $department = $row['department'];
                $tittle = $row['tittle'];


                ?>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fa-solid fa-envelope-open-text mr-2"></i> <?php echo $tittle; ?>
                  <span class="float-right text-muted text-sm"><?php echo $department; ?></span>
                </a>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>

            <div class="dropdown-divider"></div>
            <a href="report_list.php?mid=<?php echo $_GET['mid']; ?>" class="dropdown-item dropdown-footer">See All
              Notifications</a>
          </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            
            <i class="fa-solid fa-bullhorn"></i>
            <?php
            $sql = "SELECT COUNT(*) AS total FROM announcement WHERE status = 'Active'";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $total = $row['total'];


                ?>
                <span class="badge badge-warning navbar-badge"><?php echo $total; ?></span>

              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?php echo $total; ?> Notifications</span>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>



            <?php
            $sql = "SELECT *  FROM announcement WHERE status = 'Active' ORDER BY  date_created DESC LIMIT 5";
            $execute = mysqli_query($con, $sql);
            if ($execute) {
              while ($row = mysqli_fetch_array($execute)) {

                $department = $row['department'];
                $tittle = $row['tittle'];


                ?>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fa-solid fa-bullhorn mr-2"></i> <?php echo $tittle; ?>
                  <span class="float-right text-muted text-sm"><?php echo $department; ?></span>
                </a>
              <?php
              }
            } else {
              echo "<script>swal('Error', 'No Record Found!', ' error'); </script>";
            } ?>

            <div class="dropdown-divider"></div>
            <a href="announcement.php?mid=<?php echo $_GET['mid']; ?>" class="dropdown-item dropdown-footer">See All
              Notifications</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        

        <li class="nav-item">
          <a class="nav-link" href="signout.php?mid=<?php echo $_GET['mid']; ?>" role="button" style="color:red"> <i class="fa-solid fa-power-off" style="color:red"></i>
          logout
        </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->