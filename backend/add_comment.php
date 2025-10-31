<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

// Read JSON input from frontend
$inputData = json_decode(file_get_contents("php://input"), true);

// Retrieve required fields from the request body
$project_id = $inputData['project_id'] ?? '';
$user_id = $inputData['user_id'] ?? '';
$name = $inputData['name'] ?? '';
$comment = $inputData['comment'] ?? '';

// Validate all required fields
if (empty($project_id) || empty($user_id) || empty($name) || empty($comment)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// SQL query to insert a new comment
$sql = "INSERT INTO comments (project_id, user_id, name, comment) 
        VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("iiss", $project_id, $user_id, $name, $comment);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Comment added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add comment"]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>