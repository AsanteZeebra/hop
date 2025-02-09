<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Allow all origins (Modify for security)
header("Access-Control-Allow-Methods: GET");

include_once("connect.php");

// Fetch members from the database
$sql = "SELECT * FROM members LIMIT 50";
$result = $conn->query($sql);

$names = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $names[] = $row;
    }
    echo json_encode(["success" => true, "members" => $names]);
} else {
    echo json_encode(["success" => false, "message" => "No dues records found"]);
}

$conn->close();
?>
