<?php

ob_start(); // Start output buffering to avoid accidental HTML output

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

// Validate expected fields
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing email or password']);
    exit;
}

$email = $data['email'];
$password = $data['password'];

$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Password is correct
        $response = [
            'status' => 'success',
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
    } else {
        $response = ['status' => 'error', 'message' => 'Incorrect password'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'No user found with this email'];
}

ob_end_clean(); // Clear any output generated before now
echo json_encode($response);
exit;
?>
