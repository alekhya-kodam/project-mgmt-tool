<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

// Read JSON input
$inputData = json_decode(file_get_contents("php://input"), true);
$project_id = $inputData['project_id'] ?? '';

if (empty($project_id)) {
    echo json_encode(["status" => "error", "message" => "Project ID is required"]);
    exit;
}

// Update seen_by_admin = 1 for all comments of this project
$sql = "UPDATE comments SET seen_by_admin = 1 WHERE project_id = ? AND seen_by_admin = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Comments marked as seen"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update comments"]);
}

$stmt->close();
$conn->close();
?>
