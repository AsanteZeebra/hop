
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

<!-- Event List Card -->
<div class="col-md-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Upcoming Events</h5>
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once('database_connection.php');

                    $sql = "SELECT * FROM calendar_event_master ORDER BY event_id DESC LIMIT 7";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                            $event = $row['event_name'];
                            $startdate = $row['event_start_date'];
                            $enddate = $row['event_end_date'];
                            $id = $row['event_id'];
                    ?>
                            <tr>
                                <td>
                                    <b><?php echo $event; ?></b><br>
                                    <small>Start: <?php echo $startdate; ?> | End: <?php echo $enddate; ?></small>
                                </td>
                                <td>
                                    <a href="#" class="text-danger btdel" data-toggle="modal" data-target="#mdquestion">
                                        <i class="fas fa-trash" data-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='2'>No Records Found</td></tr>";
                    } ?>
                </tbody>
            </table>
            <button class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#event_entry_modal">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </div>
    </div>
</div>

<!-- Calendar Card -->
<div class="col-md-9">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Event Calendar</h5>
        </div>
        <div class="card-body">
            <div id="calendar" class="border rounded" style="height: 400px;"></div>
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