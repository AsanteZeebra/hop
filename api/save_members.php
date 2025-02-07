<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once("connect.php");
// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
    exit;
}

// Sanitize and validate input
$fullname   = htmlspecialchars(strip_tags(trim($data["fullname"] ?? '')));
$gender     = htmlspecialchars(strip_tags(trim($data["gender"] ?? '')));
$occupation = htmlspecialchars(strip_tags(trim($data["occupation"] ?? '')));
$telephone  = htmlspecialchars(strip_tags(trim($data["telephone"] ?? '')));
$address    = htmlspecialchars(strip_tags(trim($data["address"] ?? '')));

if (empty($fullname) || empty($gender) || empty($occupation) || empty($telephone) || empty($address)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO members (fullname, gender, occupation, telephone, address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $fullname, $gender, $occupation, $telephone, $address);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Member added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
