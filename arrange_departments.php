<?php
// Database connection
include_once('database_connection.php');

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 1: Select the required fields from the members table
    $sql = "SELECT member_id, fullname, gender, marital_status, age, department FROM members";
    $stmt = $pdo->query($sql);

    // Step 2: Iterate through the results and apply the conditions
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $member_id = $row['member_id'];
        $gender = $row['gender'];
        $marital_status = $row['marital_status'];
        $age = $row['age'];
        $new_department = '';

        // Step 3: Apply conditional logic to determine the new department
        if ($age >= 13 && $age <= 28 && $marital_status == 'Single') {
            $new_department = 'Youth';
        } elseif ($gender == 'Male' && ($age > 28 || $marital_status == 'Married')) {
            $new_department = 'Men';
        } elseif ($gender == 'Female' && ($age > 28 || $marital_status == 'Married')) {
            $new_department = 'Women';
        }

        // Step 4: Update the department if it has changed
        if ($new_department && $new_department !== $row['department']) {
            $updateSql = "UPDATE members SET department = :department WHERE member_id = :member_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([':department' => $new_department, ':member_id' => $member_id]);

            //echo "Updated member_id: $member_id to department: $new_department<br>";
        }
    }

    //echo "All relevant departments updated successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



include_once('database_connection.php');


$month = date('F');
$year = date('Y');
$week = date('W');
$fullweek = "week$week";

// Fetch all members
$sqlMembers = "SELECT member_id, fullname,gender FROM members";
$runMembers = mysqli_query($con, $sqlMembers);

if (mysqli_num_rows($runMembers) > 0) {
    while ($row = mysqli_fetch_assoc($runMembers)) {
        $member_id = $row['member_id'];
        $fullname = $row['fullname'];
        $gender = $row['gender'];

        // Check if the entry already exists in the attendance table
        $sqlCheck = "SELECT * FROM attendance WHERE member_id='$member_id' AND month='$month' AND year='$year' AND week='$fullweek'";
        $runCheck = mysqli_query($con, $sqlCheck);

        if (mysqli_num_rows($runCheck) == 0) {
            // Insert the new entry into the attendance table if not already present
            $sqlInsert = "INSERT INTO attendance (member_id, fullname,gender, week, month,year, status, reason) 
                          VALUES ('$member_id', '$fullname','$gender', '$fullweek', '$month','$year', 'Absent', 'No reason')";
            mysqli_query($con, $sqlInsert);
        }
    }
}




