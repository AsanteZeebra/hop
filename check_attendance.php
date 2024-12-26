<?php 

$month = date('F');
$year = date('Y');
$week = date('W');
$fullweek = "week$week";

// Fetch all members
$sqlMembers = "SELECT member_id, fullname FROM members";
$runMembers = mysqli_query($con, $sqlMembers);

if (mysqli_num_rows($runMembers) > 0) {
    while ($row = mysqli_fetch_assoc($runMembers)) {
        $member_id = $row['member_id'];
        $fullname = $row['fullname'];

        // Check if the entry already exists in the attendance table
        $sqlCheck = "SELECT * FROM attendance WHERE member_id='$member_id' AND month='$month' AND year='$year' AND week='$fullweek'";
        $runCheck = mysqli_query($con, $sqlCheck);

        if (mysqli_num_rows($runCheck) == 0) {
            // Insert the new entry into the attendance table if not already present
            $sqlInsert = "INSERT INTO attendance (member_id, fullname, week, month,year, status, reason) 
                          VALUES ('$member_id', '$fullname', '$fullweek', '$month',year, 'Absent', '')";
            mysqli_query($con, $sqlInsert);
        }
    }
}

?>
