<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the database connection file
include 'config.php';

// Decode the incoming JSON request
$inputData = json_decode(file_get_contents("php://input"), true);

// Check if 'id' is set in the decoded JSON data
if (isset($inputData['id']) && !empty($inputData['id'])) {
    $id = $inputData['id'];
    $user_id = $inputData['user_id'] ?? '';
    $name = $inputData['name'] ?? '';

    // Collect other form data from the JSON input
    $project_name = $inputData['project_name'] ?? null;
    $primary_team_lead = $inputData['primary_team_lead'] ?? null;
    $secondary_team_lead = $inputData['secondary_team_lead'] ?? null;
    $tester_name = $inputData['tester_name'] ?? null;
    $technical_skill_stack = $inputData['technical_skill_stack'] ?? null;
    $project_type = $inputData['project_type'] ?? null;
    $application_type = $inputData['application_type'] ?? null;
    $technology_partner = $inputData['technology_partner'] ?? null; // ✅ Added
    $start_date = $inputData['start_date'] ?? null;
    $internal_end_date = $inputData['internal_end_date'] ?? null;
    $client_end_date = $inputData['client_end_date'] ?? null;

    // Convert array to comma-separated string if needed
    if (is_array($application_type)) {
        $application_type = implode(',', $application_type);
    }

    // Validate the id
    if (is_numeric($id)) {
        // ✅ Updated SQL query to include technology_partner
        $query = "UPDATE project_table SET 
                    project_name = ?, 
                    primary_team_lead = ?, 
                    secondary_team_lead = ?, 
                    tester_name = ?, 
                    technical_skill_stack = ?, 
                    project_type = ?, 
                    application_type = ?, 
                    technology_partner = ?, 
                    start_date = ?, 
                    internal_end_date = ?, 
                    client_end_date = ? 
                  WHERE id = ?";

        if ($stmt = $conn->prepare($query)) {
            // ✅ Updated bind_param to include 12 parameters
            $stmt->bind_param(
                "sssssssssssi",  // 11 strings + 1 integer (id)
                $project_name,
                $primary_team_lead,
                $secondary_team_lead,
                $tester_name,
                $technical_skill_stack,
                $project_type,
                $application_type,
                $technology_partner,
                $start_date,
                $internal_end_date,
                $client_end_date,
                $id
            );

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['status' => 'success', 'message' => 'Project updated successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No changes made or project not found']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'SQL execution failed']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'SQL preparation failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not set']);
}
