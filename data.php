// data.php
<?php
// Database connection (same as before)
$dsn = 'mysql:host=localhost;dbname=hop';
$username = 'root';
$password = '0249kwaku';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

// Fetch data
$query = "SELECT * FROM dues";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return JSON response
echo json_encode($results);
?>
