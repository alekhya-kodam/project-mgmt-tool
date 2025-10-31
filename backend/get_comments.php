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

// Retrieve project_id from the request body
$project_id = $inputData['project_id'] ?? '';

// Validate project_id
if (empty($project_id)) {
    echo json_encode(["status" => "error", "message" => "Project ID is required"]);
    exit;
}

// SQL query to get comments for a project
$sql = "SELECT comments.*, users.name as user_name 
        FROM comments
        LEFT JOIN users ON comments.user_id = users.id
        WHERE comments.project_id = ?
        ORDER BY comments.created_at DESC";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind project_id parameter
$stmt->bind_param("i", $project_id);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

$comments = [];

// Fetch all results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            "id" => $row['id'],
            "comment" => $row['comment'],
            "created_at" => $row['created_at'],
            "user_id" => $row['user_id'],
            "name" => $row['user_name'],
            "seen_by_admin" => $row['seen_by_admin'] // Include this
        ];
    }
    echo json_encode(["status" => "success", "data" => $comments]);
} else {
    echo json_encode(["status" => "success", "data" => []]); // Empty array if no comments
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
