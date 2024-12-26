
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php

$mem_id = $_GET['mid'];


     $sql = "SELECT file_name FROM photos WHERE member_id='$mem_id'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
        $image = $row['file_name'];
       
      

     ?>   
          <img src="uploads/<?php echo $image ?>" class="img-circle elevation-2" alt="User Image">
          <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
        </div>
        <div class="info">
        <?php

$mem_id = $_GET['mid'];


     $sql = "SELECT fullname FROM account WHERE member_id='$mem_id'";
     $run = mysqli_query($con, $sql);
     if ($run) {
       while ($row = mysqli_fetch_assoc($run)) {

        
       
        $name = $row['fullname'];
       
      

     ?>  
          <a href="ad_dashboard.php?mid=<?php echo $_GET['mid']; ?> && dept=<?php echo $_GET['dept'] ?>" class="d-block"><?php echo $name; ?></a>
          <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
          <a href="ad_dashboard.php?mid=<?php echo $_GET['mid'] ?> && dept=<?php echo $_GET['dept'] ?>" class="nav-link ">
              <i class="nav-icon fas fa-home"></i>
              <p>
              
              Dashboard
              </p>
            </a>
          
            <li class="nav-item">
                <a href="ad_list.php?mid=<?php echo $_GET['mid']; ?> && dept=<?php echo $_GET['dept'] ?>" class="nav-link">
                <i class="nav-icon fa-solid fa-list-ol"></i>
                  <p>Womens list</p>
                </a>
              </li>

              

              <li class="nav-item">
                <a href="welfare.php?mid=<?php echo $_GET['mid']; ?> && dept=<?php echo $_GET['dept'] ?>" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                  <p>Welfare</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ad_expenses.php?mid=<?php echo $_GET['mid']; ?> && dept=<?php echo $_GET['dept'] ?>" class="nav-link">
                <i class="nav-icon fa-solid fa-file-invoice"></i>
                  <p>Expenses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="womens_report.php?mid=<?php echo $_GET['mid'] ?> && dept=<?php echo $_GET['dept'] ?>" class="nav-link">
                <i class="nav-icon fa-solid fa-print"></i>
                  <p>Reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="signout.php" class="nav-link">

                  <i class="nav-icon fa-solid fa-power-off nav-icon"></i>
                  <p>log Out</p>
                </a>
              </li>

            </ul>
          </li>

         


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
