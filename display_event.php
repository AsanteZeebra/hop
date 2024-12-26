<?php
require 'database_connection.php';

// Prepare and execute the SQL statement
$sql = "SELECT event_name, event_start_date, event_end_date,color,start_time,end_time FROM calendar_event_master";
$result = $con->query($sql);

$events = array();

// Check if the query was successful
if ($result === false) {
    // Handle query error
    $response = array('error' => 'Database query failed: ' . $con->error);
    $con->close();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Fetch and format the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = array(
            'title' => $row['event_name'],
            'event_date' => $row['event_start_date'],
            'end_date' => $row['event_end_date'],
            'color' => $row['color'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time']
        );
    }
}

// Close the database connection
$con->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($events);
?>
