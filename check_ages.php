<?php
// Assuming you already have a connection to the database in $con

// Check if member_id is provided via GET or POST request
$member_id = $_GET['uid'] ?? null;

if ($member_id) {
    // Sanitize and prepare the query using prepared statements
    $stmt = $con->prepare("SELECT dob FROM members WHERE member_id = ?");
    $stmt->bind_param("s", $member_id); // "s" denotes the type string

    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Get date of birth
            $date_of_birth = $row['dob'];
            
            // Calculate age
            $dob = new DateTime($date_of_birth);
            $today = new DateTime('today');
            $age = $dob->diff($today)->y;
            
            // Update the age in the members table
            $update_stmt = $con->prepare("UPDATE members SET age = ? WHERE member_id = ?");
            $update_stmt->bind_param("is", $age, $member_id); // "i" for integer, "s" for string

            if ($update_stmt->execute()) {
                //echo "The age of member with ID $member_id has been updated to $age years.";
            } else {
                echo "Update Error: " . $con->error;
            }
            
          

        } else {
            echo "No member found with ID $member_id.";
        }
    } else {
        // Print error message
        echo "Query Error: " . $con->error;
    }

  

} else {
    echo "No member ID provided.";
}
?>
