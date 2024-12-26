<?php 
// Connect to the database (replace with your actual connection details)
$pdo = new PDO('mysql:host=localhost;dbname=hop', 'root', '0249kwaku');

// Calculate the date 12 weeks ago
$date_12_weeks_ago = date('Y-m-d', strtotime('-12 weeks'));

// Step 1: Get all users from the users table
$query = "
    SELECT id 
    FROM members 
    WHERE status != 'Inactive'
";

$stmt = $pdo->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Step 2: Loop through each user and check their attendance
foreach ($users as $user) {
    $user_id = $user['id'];

    // Step 3: Count absences over the past 12 weeks
    $absence_query = "
        SELECT COUNT(*) AS absence_count
        FROM attendance
        WHERE member_id = :user_id
        AND attendance_date >= :date_12_weeks_ago
        AND status = 'absent'
    ";

    $absence_stmt = $pdo->prepare($absence_query);
    $absence_stmt->execute([
        ':user_id' => $user_id,
        ':date_12_weeks_ago' => $date_12_weeks_ago,
    ]);

    $absence_result = $absence_stmt->fetch(PDO::FETCH_ASSOC);

    // Step 4: If the user has been absent for 12 weeks, update their status to 'Inactive'
    if ($absence_result['absence_count'] > 0) {
        $update_query = "
            UPDATE members
            SET status = 'Inactive'
            WHERE member_id = :user_id
        ";

        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([':user_id' => $user_id]);

        echo "User ID $user_id status updated to Inactive.<br>";
    } else {
        echo "User ID $user_id has not been absent for 12 weeks.<br>";
    }
}
