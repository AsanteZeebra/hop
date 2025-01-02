<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Schedule | Manage Event</title>

  
    <?php include_once('head.php'); ?>
</head>

<body class="hold-transition sidebar-mini bg-light">
    <div class="wrapper">
        <?php include_once('navbar.php'); ?>
        <?php include_once('sidebar.php'); ?>

        <div class="content-wrapper">
            <!-- Page Header -->
            <section class="content-header py-3 bg-white shadow-sm">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">Event Schedule</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Event</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="content mt-3">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-outline-secondary btn-sm back">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#event_entry_modal">
                            <i class="fas fa-plus"></i> Add Event
                        </button>
                    </div>

                    <div class="row">
                        <!-- Event List -->
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Recent Events</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th>Dates</th>
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
                                                    <td><b><?php echo $event; ?></b></td>
                                                    <td>
                                                        <small><b>Start:</b> <?php echo $startdate; ?> <br>
                                                        <b>End:</b> <?php echo $enddate; ?></small>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="text-danger" data-toggle="modal" data-target="#mdquestion" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No Records Found</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar -->
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Calendar</h5>
                                </div>
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include_once('footer.php'); ?>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="event_entry_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="event_form">
                        <!-- Form Fields -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include_once('script.php'); ?>
    
   <script>
        $('.back').click(function () {
            window.history.back();
        });
    </script>
</body>

</html>
