
<?php include_once('database_connection.php');


include_once('load_session.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Schedule| Manage Event</title>


    <?php include_once('head.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
       <?php include_once('navbar.php') ?>
        <!-- /.navbar -->
        <?php include_once('sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

        </section>
   
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Event Schedule</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Event</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <button class="btn btn-primary btn-sm back" style="margin-left:10px"><i class="fa fa-arrow-left"></i> Back</button>
     <br>
     <br>
        <!-- Delete profile modal -->
       <div class="modal fade" id="mdquestion" style="margin-top: 15%;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="width: 100%; text-align: center;">Are you Sure Want to Delete<i class="fa fa-question"></i></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form method="post">
                                <div class='row'  >
                                  <div class='col-4' >
                                  <input  type="text" hidden class='form-control ddt'>
                                  </div>
                                
                                
                                 </div>
                                    <center>
                                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-danger bbt">Yes</button>
                                    </center>
                                </form>
                                   
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
  
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">

                    <div class="col-3">
                        <div class="card">
                            <div class="card-body" scrolable>

                                <table class="table">
                                    <thead>
                                        <tr>
                                           
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                  include_once('database_connection.php');
                  
                  $sql = "SELECT * from  calendar_event_master ORDER BY event_id DESC LIMIT 7 ";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                     
                      $event = $row['event_name'];
                      $startdate = $row['event_start_date'];
                      $enddate = $row['event_end_date'];
                      $id = $row['event_id'];
     
                  ?>
                                    <tr>
                                        <td hidden><?php echo $id ?></td>
                                        <td><b><?php echo $event; ?></b> <br>
                                    <small><b>Start:</b> <?php echo $startdate ?>  <b>End:</b> <?php echo $enddate ?></small>
                                    </td>
                                        <td><a href="#" class="fa-solid fa-trash  btdel " data-toggle='modal' data-target="#mdquestion" style="color:red"></a></td>
                                    </tr>
                                    <?php    }
                  } else {
                    echo "No Records Found";
                  } ?>
                                    </tbody>
                            
                                </table>
                                <hr>
<a href="" data-target="#event_entry_modal" data-toggle="modal" class="btn btn-primary btn-sm" style="float:right;">Add event</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-9">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div id="calendar"></div>
                                <!-- Start popup dialog box -->
                                <div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog"
                                    aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Add New Event</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="img-container">
                                          <form method="post" id="event">
                                          <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="event_name">Event name</label>
                                                                <input type="text" name="event_name" id="event_name"
                                                                    class="form-control tfname"
                                                                    placeholder="Enter your event name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="event_start_date">Event start</label>
                                                                <input type="date" name="event_start_date"
                                                                    id="event_start_date"
                                                                    class="form-control tfstart"
                                                                    placeholder="Event start date">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="event_end_date">Event end</label>
                                                                <input type="date" name="event_end_date"
                                                                    id="event_end_date" class="form-control tfend"
                                                                    placeholder="Event end date">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="event_start_time">Start Time</label>
                                                                <input type="time" name="event_start_time"
                                                                    id="event_start_time" class="form-control tftimestart"
                                                                    placeholder="Start Time">
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="event_end_time">End Time</label>
                                                                <input type="time" name="event_end_time"
                                                                    id="event_end_time" class="form-control tftimeend"
                                                                    placeholder="End Time">
                                                            </div>
                                                        </div>

                                                      
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save Event</button>
                                            </div>
                                            
                                          </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End popup dialog box -->

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

 

    <?php include_once('script.php'); ?>
    <script src="calender.js"></script>
</body>

<?php  
include_once('validate_event.php'); 

?>



<script>
    $('.back').click(function () {
      if (document.referrer) {
        window.location.href = document.referrer;
      } else {
        window.history.back();
      }

    });

  </script>


</html>