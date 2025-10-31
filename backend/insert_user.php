<?php

// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");


header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Content-Type: application/json"); 


include "config.php";


// Get the POST data from the request
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash the password before storing it
$role = $data['role'];

// Prepare an SQL statement to insert the data
$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";

// Prepare and bind the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $password, $role);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["message" => "User registered successfully!"]);
} else {
    echo json_encode(["message" => "Error: " . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
