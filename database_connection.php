

<?php



    static $con = null; // Static variable to persist the connection

    if ($con === null) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "0249kwaku";
        $dbname = "hop";

        // Create a new connection
        $con = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
    }

   
?>
