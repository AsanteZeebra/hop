

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Passowrd</title>

 <?php include_once('head.php') ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <!-- <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a> -->
       <img src="dist/img/hop1.png" alt="" style="width: 150px; height: 150px;">
    </div>
    <div class="card-body">
      <p class="login-box-msg"><center><h3>Reset Password</h3></center></p>
      <form id="acform" method="post">
      <div class="input-group mb-3">
          <input type="text" name="memid" class="form-control tfmemid" placeholder="Member_ID">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control tfpass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="resetpassword" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block submit-btn">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php include_once('script.php') ?>
<script src="reset_password.js?t=12345"></script>
</body>
</html>
