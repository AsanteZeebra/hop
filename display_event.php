<?php
header('Content-Type: application/json');
include_once('database_connection.php');

$sql = "SELECT 
            event_name AS title, 
            event_start_date AS event_date, 
            event_start_time AS start_time, 
            event_end_date, 
            event_end_time, 
            '#007bff' AS color 
        FROM calendar_event_master";
$result = mysqli_query($con, $sql);

if ($result) {
    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode(["error" => mysqli_error($con)]);
}
?>
