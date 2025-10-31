<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the database connection file
include 'config.php'; // Make sure this file contains the proper connection code

// Get POST data (check the raw POST data)
$data = json_decode(file_get_contents("php://input"));

// Check if project_id is provided
$project_id = isset($data->project_id) ? $data->project_id : '';

// Debug log to check if project_id is being received
file_put_contents('php://stderr', "Received project_id: $project_id\n");

// Check if project_id is not empty
if ($project_id != '') {
    // SQL query to fetch responses based on project_id from the responses table
    $query = "
        SELECT r.id, r.response_text, r.responded_by, r.response_date
        FROM responses r
        INNER JOIN project_table p ON r.project_id = p.id
        WHERE r.project_id = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the project_id parameter
        $stmt->bind_param("i", $project_id);  // 'i' for integer

        // Execute the statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $responses = [];

                // Fetch all the responses
                while ($row = $result->fetch_assoc()) {
                    $responses[] = $row;
                }

                // Return the response as JSON
                echo json_encode([
                    'status' => 'success',
                    'data' => $responses
                ]);
            } else {
                echo json_encode([
                    'status' => 'failure',
                    'message' => 'No responses found for the given project'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'failure',
                'message' => 'Error executing the query'
            ]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'failure',
            'message' => 'Failed to prepare the query'
        ]);
    }
} else {
    // If project_id is missing
    echo json_encode([
        'status' => 'failure',
        'message' => 'Project ID is missing'
    ]);
}

// Close the database connection
$conn->close();
