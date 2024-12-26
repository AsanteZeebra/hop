<?php 

include_once('database_connection.php');

include_once('load_session.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Member Registration</title>
  <?php include_once('head.php'); ?>
 
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('navbar.php'); ?>
  <!-- /.navbar -->
  <?php include_once('sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="margin-left:100px">Member Registration Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registration</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row" style="justify-content:center">

 <div class="col-10" >
  <div class="card card-primary">
  <div class="card-header">
  <h3 class="card-title">Please fill all relevant spaces</h3>
  </div>
    <div class="card-body">

  <form method="post" id="member_form">
  <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              
              </div>
              <div class="card-body p-0">
                <div class="bs-stepper">
                  <div class="bs-stepper-header" role="tablist">
                     <!-- your steps here -->
                     <div class="step" data-target="#logins-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                        <span class="bs-stepper-circle"><i class="fa-regular fa-user"></i></span>
                        <span class="bs-stepper-label">Personal information</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#information-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                        <span class="bs-stepper-circle"><i class="fa-solid fa-users"></i></span>
                        <span class="bs-stepper-label">Family information</span>
                      </button>
                    </div>
                  </div>
                  <div class="bs-stepper-content">
                    <!-- your steps content here -->
                    <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                      <div class="form-group">
                        <label>FullName</label>
                        <input type="text" class="form-control tfname" name="fullname"  placeholder="Enter FullName">
                      </div>

                      <div class="row">
                      <div class="col-4">
                    <div class="form-group">
                  <label>Date of Birth:</label>
                  
                        <input type="date" class="form-control  tfdob" name="dob">
                       
                    </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                       <label for="">Age:</label>
                       <input type="text" class="form-control tfage" name="age" placeholder="Age" readonly>
                      </div>
                    </div>

                    <div class="col-4">
                    <div class="form-group">
                  <label>Date of 'Alter call':</label>
                   <input type="date" class="form-control tfalter" name="altercall">
                    </div>
                    </div>

                    </div>
                    
                     <div class="row">
                       <div class="col-6">
                       <div class="form-group">
                        <label for="">Gender</label>
                       <select class="form-control cbgender" name="gender">
                    <option value="" selected="selected"> --Gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                      </div>
                       </div>

                      
                       <div class="col-6">
                       <div class="form-group">
                        <label for="">Marital Status</label>
                       <select class="form-control cbmarital" name="marital">
                    <option value="" selected="selected"> --Marital Status--</option>
                    <option value="Single">Single</option>
                    <option Vaalue="Married">Married</option>  
                    <option valaue="Divorced">Divorced</option>   
                    <option valaue="Widowed">Widowed</option>               
                  </select>
                      </div>
                       </div>
                     </div>
                       
                     <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Occupation</label>
                          <input type="text" class="form-control tfoccupation" placeholder="Occupation" name="occupation">
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="form-group">
                          <label for="">Telephone</label>
                          <input type="tel" class="form-control tftel" placeholder="Telephone" name="telephone">
                        
                        </div>
                      </div>


                     </div>
                     
                      <button type="button" class="btn btn-primary nextbtn" onclick="stepper.next()">Next</button>
                    </div>
                    <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                      
                     
                    <div class="form-group">
                        <label for="exampleInputPassword1">Spouse Name</label>
                        <input type="text" class="form-control tfspouse"  placeholder="Name of Husband / Wife" name="spouse">
                      </div>

                      <div class="row">
                        <div class="col-4">
                          <div class="form-group">
                            <label for="">No. of Children</label>
                            <input type="text" class="form-control tfchild" placeholder="Number of children" name="children">
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="">City/Town</label>
                            <input type="text" class="form-control tfcity" placeholder="City/Town" name="city">
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                            <label for="">Region</label>
                            <input type="text" class="form-control tfregion" placeholder="Region" name="region">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-8">
                          <div class="form-group">
                           <label for="">Residence Address</label>
                           <textarea class="form-control tfresidence"   cols="30" rows="3" placeholder="House address" name="houseaddress"></textarea>
                          </div>
                        </div>

                        <div class="col-4">
                          <div class="form-group">
                           <label for="">Postal Address</label>
                           <textarea class="form-control tfpostal"  cols="30" rows="3" placeholder="P.O.Box" name="postbox"></textarea>
                          </div>
                        </div>
                      </div>  
                       
                      <div class="col-12">
                        <div class="form-group">
                          <label for="">Next of kin:</label>
                          <input type="text" class="form-control tfnextofkin" placeholder="Next of kin" name="nextofkin">
                        </div>
                      </div>
                      <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                      <button type="submit"  class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
       
  </form>

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

<script src="validate_member.js"></script>


</body>
</html>
