<?php

// Set headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include database configuration
include 'config.php'; // Make sure this file sets up $conn (mysqli)

// SQL query to fetch latest project status with start and end dates
$sql = "
SELECT 
    pt.id AS project_id, 
    pt.project_name, 
    pt.start_date,
    pt.client_end_date,
    COALESCE(st.status_percentage, 0) AS status_percentage,
    COALESCE(st.status, 'In Progress') AS status
FROM project_table pt
LEFT JOIN (
    SELECT s1.project_id, s1.status_percentage, s1.status
    FROM status_table s1
    INNER JOIN (
        SELECT project_id, MAX(created_at) AS latest_status
        FROM status_table
        GROUP BY project_id
    ) s2 ON s1.project_id = s2.project_id AND s1.created_at = s2.latest_status
) st ON pt.id = st.project_id;
";

// Execute query
$result = $conn->query($sql);

$projects = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = [
            'project_id' => $row['project_id'],
            'project_name' => $row['project_name'],
            'start_date' => $row['start_date'],          // included here
            'client_end_date' => $row['client_end_date'],// included here
            'status_percentage' => $row['status_percentage'],
            'status' => $row['status']
        ];
    }
}

// Return JSON response
echo json_encode(['projects' => $projects]);

?>
