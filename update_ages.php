<?php

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '0249kwaku';
$dbname = 'fremepxt_hop';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select all members
$sql = "SELECT id, dob FROM members";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $dob = $row['dob'];

        // Check if dob is valid
        if (!empty($dob) && strtotime($dob) !== false) {
            $age = date_diff(date_create($dob), date_create('today'))->y;

            // Update age
            $update = $conn->prepare("UPDATE members SET age = ? WHERE id = ?");
            $update->bind_param("ii", $age, $id);
            $update->execute();
            $update->close();
        }
        // Optionally, handle members with invalid dob here
    }
    //echo "Ages updated successfully.";
} else {
    echo "No members found.";
}

$conn->close();
?>
