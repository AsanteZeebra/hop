
<?php 



include_once('arrange_departments.php');
include_once('check_dues.php');

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login </title>

<?php include_once('head.php'); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
 
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <!-- <a href="#" class="h1"><b>Admin</b>LTE</a> -->
      <img src="dist/img/hop1.png" alt="hop logo" class="h1" style="width: 150px; height: 150px;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="acform" method="post" action="login.php">
    
        
        <div class="input-group mb-3">
          <input type="text" name="mem_id" class="form-control member_id" placeholder="Member_ID" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
         <input type="password" name="password" class="form-control tfpass" placeholder="Password" required>
        
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
         
          <div class="col-12" >
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        
          <!-- /.col -->
        </div>
      </form>
      <p class="mb-1">
        <a href="reset_password.php">I forgot my password</a>
      </p>
     
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<?php include_once('script.php'); ?>
<!-- <script src="validate_index.js?t=123"></script> -->
</body>
</html>
