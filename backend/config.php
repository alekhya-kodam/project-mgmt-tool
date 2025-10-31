<?php
// $servername = "127.0.0.1";
// $username = "root";
// $password = "Root@1234";
// $database = "project_list";
// $port = 3306; // Optional, default is 3306

$servername = "localhost";
$username = "root";
$password = "";
$database = "project_list";
$port = 3307; 


// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    //    echo "Connected to MySQL database";
}
?>