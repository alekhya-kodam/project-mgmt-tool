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

// Retrieve user_id from the request body
$user_id = $inputData['user_id'] ?? '';

// Base SQL query
$sql = "SELECT project_table.*, 
               status_table.status, 
               status_table.status_description
        FROM project_table
        LEFT JOIN status_table 
        ON project_table.id = status_table.project_id 
        AND status_table.is_latest = 1";

// If user_id is provided (teamlead), add WHERE condition
if (!empty($user_id)) {
    $sql .= " WHERE project_table.user_id = ?";
}

// Add ORDER BY clause
$sql .= " ORDER BY project_table.id DESC";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind user_id if needed
if (!empty($user_id)) {
    $stmt->bind_param("i", $user_id);
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

$projects = [];

// Fetch all results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $projects]);
} else {
    echo json_encode(["status" => "success", "data" => []]); // Empty array if no projects
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
