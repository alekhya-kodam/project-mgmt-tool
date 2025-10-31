<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the database connection file
include 'config.php'; // Ensure this file contains the correct database connection

// Read JSON input from frontend
$inputData = json_decode(file_get_contents("php://input"), true);

// Retrieve user_id and name from the POST request body
$user_id = $inputData['user_id'] ?? '';  // user_id should be passed from the frontend
$name = $inputData['name'] ?? '';        // name should be passed from the frontend

// SQL query to fetch project details along with status percentage, ensuring user_id is matched
$sql = "
SELECT pt.id AS project_id, 
       pt.project_name, 
       COALESCE(st.status_percentage, 0) AS status_percentage
FROM project_table pt
LEFT JOIN (
    SELECT s1.project_id, s1.status_percentage
    FROM status_table s1
    INNER JOIN (
        SELECT project_id, MAX(created_at) AS latest_status
        FROM status_table
        GROUP BY project_id
    ) s2 ON s1.project_id = s2.project_id AND s1.created_at = s2.latest_status
) st ON pt.id = st.project_id
WHERE pt.user_id = ?";  // Ensure user_id is filtered for the logged-in user

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind the user_id parameter to the query

$stmt->execute();
$result = $stmt->get_result();

$projects = [];

// Fetch the results and store them in the $projects array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = [
            'project_name' => $row['project_name'],
            'status_percentage' => $row['status_percentage']
        ];
    }
}

// Return the projects as a JSON response
echo json_encode(['projects' => $projects]);

// Close the database connection
$conn->close();
?>
