<?php

// Database connection


try {
    // Create connection to members database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select fullname, member_id, and department from members
    $sql_select = "SELECT fullname, member_id, department FROM members";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->execute();

    // Prepare the insert statement for dues
    $sql_insert = "INSERT INTO dues (fullname, member_id, amount, department, month, year, date_created, status, week) 
                   VALUES (:fullname, :member_id, :amount, :department, :month, :year, :date_created, :status, :week)";
    $stmt_insert = $conn->prepare($sql_insert);

    // Loop through the results from members
    while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
        // Replace these with actual values or gather them dynamically
        $amount = 0; // Example amount
        $month = date('F'); // Current month
        $year = date('Y');  // Current year
        $date = date('Y-m-d'); // Current date
        $status = "Unpaid"; // Status
        $week = date('W'); // Current week

        // Check if the record already exists
        $sql_check = "SELECT COUNT(*) FROM dues WHERE member_id = :member_id AND month = :month AND year = :year AND week = :week AND department = :department";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':member_id', $row['member_id']);
        $stmt_check->bindParam(':month', $month);
        $stmt_check->bindParam(':year', $year);
        $stmt_check->bindParam(':week', $week);
        $stmt_check->bindParam(':department', $row['department']);
        $stmt_check->execute();

        // If no record exists, proceed with the insert
        if ($stmt_check->fetchColumn() == 0) {
            // Bind parameters and execute the insert
            $stmt_insert->bindParam(':fullname', $row['fullname']);
            $stmt_insert->bindParam(':member_id', $row['member_id']);
            $stmt_insert->bindParam(':amount', $amount);
            $stmt_insert->bindParam(':department', $row['department']);
            $stmt_insert->bindParam(':month', $month);
            $stmt_insert->bindParam(':year', $year);
            $stmt_insert->bindParam(':week', $week);
            $stmt_insert->bindParam(':date_created', $date);
            $stmt_insert->bindParam(':status', $status);
            $stmt_insert->execute();
        }
    }

    //echo "Data inserted successfully where applicable.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}






// Database connection


try {
    // Create connection to members database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select fullname, member_id, and department from members
    $sql_select = "SELECT fullname, member_id, department FROM members";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->execute();

    // Prepare the insert statement for dues
    $sql_insert = "INSERT INTO dues (fullname, member_id, amount, department, month, year, date_created, status, week) 
                   VALUES (:fullname, :member_id, :amount, :department, :month, :year, :date_created, :status, :week)";
    $stmt_insert = $conn->prepare($sql_insert);

    // Loop through the results from members
    while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
        // Replace these with actual values or gather them dynamically
        $amount = 0; // Example amount
        $month = date('F'); // Current month
        $year = date('Y');  // Current year
        $date = date('Y-m-d'); // Current date
        $status = "Unpaid"; // Status
        $week = date('W'); // Current week
        $department ="Main"; // Department

        // Check if the record already exists
        $sql_check = "SELECT COUNT(*) FROM dues WHERE member_id = :member_id AND month = :month AND year = :year  AND department = :department";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':member_id', $row['member_id']);
        $stmt_check->bindParam(':month', $month);
        $stmt_check->bindParam(':year', $year);
    
        $stmt_check->bindParam(':department', $department);
        $stmt_check->execute();

        // If no record exists, proceed with the insert
        if ($stmt_check->fetchColumn() == 0) {
            // Bind parameters and execute the insert
            $stmt_insert->bindParam(':fullname', $row['fullname']);
            $stmt_insert->bindParam(':member_id', $row['member_id']);
            $stmt_insert->bindParam(':amount', $amount);
            $stmt_insert->bindParam(':department', $department);
            $stmt_insert->bindParam(':month', $month);
            $stmt_insert->bindParam(':year', $year);
            $stmt_insert->bindParam(':week', $week);
            $stmt_insert->bindParam(':date_created', $date);
            $stmt_insert->bindParam(':status', $status);
            $stmt_insert->execute();
        }
    }

    //echo "Data inserted successfully where applicable.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


