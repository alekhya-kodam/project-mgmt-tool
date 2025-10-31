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

// Retrieve user_id and name from the request body
$user_id = $inputData['user_id'] ?? '';
$name = $inputData['name'] ?? '';

// Basic validation for user_id (teamlead will pass user_id, admin won't)
if (empty($user_id) && empty($inputData['user_id'])) {
    // If user_id is empty (which happens for admin), fetch all projects
    $sql = "SELECT * FROM project_table ORDER BY id DESC";
} else {
    // If user_id is provided (which happens for teamlead), fetch only user-related projects
    $sql = "SELECT * FROM project_table WHERE user_id = ? ORDER BY id DESC";
}

$stmt = $conn->prepare($sql);

// If user_id exists, bind it to the query
if (!empty($user_id)) {
    $stmt->bind_param("i", $user_id);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $projects]);
} else {
    echo json_encode(["status" => "success", "data" => []]); // Return empty array if no projects found
}

$stmt->close();
$conn->close();
?>
