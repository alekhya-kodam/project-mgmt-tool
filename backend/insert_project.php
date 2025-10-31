<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include "config.php";

$inputData = json_decode(file_get_contents("php://input"), true);

// Extract and sanitize inputs
$user_id = $inputData['user_id'] ?? '';
$name = $inputData['name'] ?? '';
$project_name = $inputData['project_name'] ?? '';
$primary_team_lead = $inputData['primary_team_lead'] ?? '';
$secondary_team_lead = $inputData['secondary_team_lead'] ?? '';
$tester_name = $inputData['tester_name'] ?? '';
$start_date = $inputData['start_date'] ?? '';
$internal_end_date = $inputData['internal_end_date'] ?? '';
$client_end_date = $inputData['client_end_date'] ?? '';
$technical_skill_stack = $inputData['technical_skill_stack'] ?? '';
$project_type = $inputData['project_type'] ?? '';
$application_type = isset($inputData['application_type']) && is_array($inputData['application_type'])
    ? implode(',', $inputData['application_type'])
    : '';
$technology_partner = $inputData['technology_partner'] ?? '';

// Basic validation
if (empty($project_name) || empty($primary_team_lead) || empty($start_date) || empty($technology_partner)) {
    echo json_encode(["status" => "error", "message" => "Required fields are missing."]);
    exit;
}

$sql = "INSERT INTO project_table (
    user_id,
    name,
    project_name,
    primary_team_lead,
    secondary_team_lead,
    tester_name,
    start_date,
    internal_end_date,
    client_end_date,
    technical_skill_stack,
    project_type,
    application_type,
    technology_partner
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param(
    "issssssssssss",
    $user_id,
    $name,
    $project_name,
    $primary_team_lead,
    $secondary_team_lead,
    $tester_name,
    $start_date,
    $internal_end_date,
    $client_end_date,
    $technical_skill_stack,
    $project_type,
    $application_type,
    $technology_partner
);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Project added successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Execution failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
