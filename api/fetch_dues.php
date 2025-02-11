<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Allow all origins (Modify for security)
header("Access-Control-Allow-Methods: GET");

include_once("connect.php");

// Fetch members from the database
$sql = "SELECT * FROM dues LIMIT 50";
$result = $conn->query($sql);

$dues = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dues[] = $row;
    }
    echo json_encode(["success" => true, "dues" => $dues]);
} else {
    echo json_encode(["success" => false, "message" => "No dues records found"]);
}

$conn->close();
?>
