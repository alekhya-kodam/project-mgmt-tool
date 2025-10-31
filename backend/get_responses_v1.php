<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include database connection settings
include "config.php"; // Ensure this file has the correct connection details

// Get POST data
$data = json_decode(file_get_contents("php://input"));
$comment_id = isset($data->comment_id) ? $data->comment_id : '';
$project_id = isset($data->project_id) ? $data->project_id : '';

// Validate that both comment_id and project_id are present
if ($comment_id != '' && $project_id != '') {
    // SQL query to fetch comment and related responses for a specific comment_id and project_id
    $query = "
        SELECT c.comment, c.created_at AS comment_created, r.response_text, r.responded_by, r.response_date
        FROM comments c
        LEFT JOIN responses r ON c.id = r.comment_id
        WHERE c.id = ? AND r.project_id = ?";  // Using both comment_id and project_id to filter results

    // Prepare the query
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters (comment_id and project_id) to the query
        $stmt->bind_param("ss", $comment_id, $project_id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch data into an array
            $responses = [];

            while ($row = $result->fetch_assoc()) {
                $responses[] = $row;
            }

            // Return the success response with the fetched data
            echo json_encode([
                'status' => 'success',
                'data' => $responses
            ]);
        } else {
            // No responses found
            echo json_encode([
                'status' => 'failure',
                'message' => 'No responses found for the given comment'
            ]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Query preparation failed
        echo json_encode([
            'status' => 'failure',
            'message' => 'Failed to prepare the query'
        ]);
    }
} else {
    // Invalid request if comment_id or project_id is missing
    echo json_encode([
        'status' => 'failure',
        'message' => 'Invalid request: comment_id and project_id are required'
    ]);
}

// Close the database connection
$conn->close();
?>


