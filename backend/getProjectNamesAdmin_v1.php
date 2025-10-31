<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'config.php'; // Database connection

$sql = "
SELECT 
    pt.id AS project_id, 
    pt.project_name, 
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

$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = [
            'project_name' => $row['project_name'],
            'status_percentage' => $row['status_percentage'],
            'status' => $row['status']
        ];
    }
}

echo json_encode(['projects' => $projects]);

?>
