<?php

include_once('database_connection.php');

// Use prepared statements to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM account WHERE member_id = ?");
$stmt->bind_param("s", $_POST['mem_id']);

$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows == 1) {
    $memberDetails = $result->fetch_assoc();

    // Verify the password using password_verify()
    if (password_verify($_POST['password'], $memberDetails['password'])) {
        session_start();

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["member_id"] = $memberDetails['member_id'];
        $_SESSION["role"] = $memberDetails['role'];


        function getPublicIp()
        {
            // Fetch public IP address from ipify API
            $publicIp = file_get_contents('https://api.ipify.org');
            return $publicIp;
        }

        $ip_address = getPublicIp();



        // Insert member details into online_users table
        $login_time = date('Y-m-d H:i:s');  // Get the current date and time
        $status = 'logged_in';

        // Prepare the insert statement for the online_users table
        $insert_stmt = $con->prepare("INSERT INTO activity_logs (member_id, fullname,role, login_time, status,ip_address) VALUES (?,?,?, ?, ?, ?)");
        $insert_stmt->bind_param("ssssss", $memberDetails['member_id'], $memberDetails['fullname'], $memberDetails['role'], $login_time, $status, $ip_address);

        // Execute the insert statement
        if ($insert_stmt->execute()) {
            // Insertion was successful, continue with the redirection based on the role
            switch ($memberDetails['role']) {
                case 'Superadmin':
                    header("Location: dashboard.php?mid=".urlencode($memberDetails['member_id']));
                    break;
                case 'Warefareadmin':
                    header("Location: ad_dashboard.php?mid=".urlencode($memberDetails['member_id'])."&& dept=Main");
                    break;
                case 'Womensadmin':
                    header("Location: ad_dashboard.php?mid=".urlencode($memberDetails['member_id'])."&& dept=Women");
                    break;
                case 'Mensadmin':
                    header("Location: ad_dashboard.php?mid=".urlencode($memberDetails['member_id'])."&& dept=Men");
                    break;
                case 'Youthadmin':
                    header("Location: ad_dashboard.php?mid=".urlencode($memberDetails['member_id'])."&& dept=Youth" );
                    break;
                case 'Attendance':
                    header("Location: att_dash.php?mid=".urlencode($memberDetails['member_id']));
                    break;
                case 'Registration':
                    header("Location: registration.php?mid=".urlencode($memberDetails['member_id']));
                    break;
                default:
                    echo json_encode(["status" => "unknown_role"]);
                    exit;
            }

            // Regenerate session ID for security
            session_regenerate_id(true);
            exit;
        } else {
            // Handle error if the insertion failed
            echo json_encode(["status" => "db_insert_error"]);
            exit;
        }

    } else {
        // Invalid password
        echo json_encode(["status" => "invalid_credentials"]);
        exit;
    }

} else {
    // Invalid member_id or SQL execution error
    echo json_encode(["status" => "invalid_credentials_or_query_error"]);
    exit;
}

?>