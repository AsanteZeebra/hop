<?php
// Database connection
    $host = "localhost";
        $username = "root";
        $password = "0249kwaku";
        $database = "fremepxt_hop";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}
?>