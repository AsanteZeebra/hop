
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
          <a href="dashboard.php?mid=<?php echo $_GET['mid']; ?>" class="d-block"><?php echo $name; ?></a>
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
            <a href="registration.php?mid=<?php echo $_GET['mid']; ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
               
              </p>
            </a>
            
              <li class="nav-item">
                <a data-toggle="modal" data-target="#modal-lg" class="nav-link">
                <i class="nav-icon fa-solid fa-user-group"></i>
                  <p>Add Member</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="#" data-toggle="modal" data-target="#float" class="nav-link">
                <i class="nav-icon fa fa-arrow-circle-right"></i>
                  <p>Move To</p>
                </a>
              </li>
             
             

               <li class="nav-item">
                <a href="#?mid=<?php echo $_GET['mid']; ?>" class="nav-link">
                   <i class="nav-icon fa fa-print"></i>
                  <p>Report</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="signout.php?mid=<?php echo $_GET['mid']; ?>" class="nav-link">
                   <i class="nav-icon fa-solid fa-power-off"></i>
                  <p>Log out</p>
                </a>
              </li>

              
           
          </li>

          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
