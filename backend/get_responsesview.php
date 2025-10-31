<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST"); // Added GET method
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

// Function to handle both GET and POST requests
function getResponses($conn) {
    // Check request method
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Retrieve project_id based on request method
    if ($method == 'GET') {
        $project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;
    } else {
        $inputData = json_decode(file_get_contents("php://input"), true);
        $project_id = $inputData['project_id'] ?? 0;
    }

    // Validate project_id
    if (empty($project_id) || $project_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Valid Project ID is required"]);
        exit;
    }

    // SQL query to get responses for a project with user information
    $sql = "SELECT responses.*, users.name as responder_name 
            FROM responses
            LEFT JOIN users ON responses.responded_by = users.id
            WHERE responses.project_id = ?
            ORDER BY responses.response_date DESC";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database preparation error: " . $conn->error]);
        exit;
    }

    // Bind project_id parameter
    $stmt->bind_param("i", $project_id);

    // Execute the statement
    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Database execution error: " . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();
    $responses = [];

    // Fetch all results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $responses[] = [
                "id" => $row['id'],
                "user_id" => $row['user_id'],
                "project_id" => $row['project_id'],
                "comment_id" => $row['comment_id'],
                "response_text" => $row['response_text'],
                "responded_by" => $row['responded_by'],
                "responder_name" => $row['responder_name'],
                "response_date" => $row['response_date']
            ];
        }
        echo json_encode(["status" => "success", "data" => $responses]);
    } else {
        echo json_encode(["status" => "success", "data" => []]); // Empty array if no responses
    }

    // Close statement
    $stmt->close();
}

// Call the function with database connection
getResponses($conn);

// Close connection
$conn->close();
?>