<?php
include_once('database_connection.php');

function generateRandomColor() {
    // Generate random values for red, green, and blue
    $red = dechex(rand(0, 255));
    $green = dechex(rand(0, 255));
    $blue = dechex(rand(0, 255));

    // Make sure each color component has two digits
    $red = str_pad($red, 2, '0', STR_PAD_LEFT);
    $green = str_pad($green, 2, '0', STR_PAD_LEFT);
    $blue = str_pad($blue, 2, '0', STR_PAD_LEFT);

    // Concatenate and return the color code
    return "#$red$green$blue";
}



// Prepare and sanitize the input
$event_name = mysqli_real_escape_string($con, $_POST['event']);
$event_start_date = date("Y-m-d", strtotime($_POST['start']));
$event_end_date = date("Y-m-d", strtotime($_POST['end']));
$start_time = mysqli_real_escape_string($con,$_POST['start_time']);
$end_time = mysqli_real_escape_string($con,$_POST['end_time']);
$color = generateRandomColor();

// Use a prepared statement to prevent SQL injection
$stmt = $con->prepare("INSERT INTO calendar_event_master(event_name, event_start_date, event_end_date,color,start_time,end_time) VALUES (?, ?, ?,?,?,?)");
$stmt->bind_param("ssssss", $event_name, $event_start_date, $event_end_date, $color,$start_time,$end_time);

if ($stmt->execute()) {
    echo "Event created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
