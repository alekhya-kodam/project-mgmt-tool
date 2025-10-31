<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'config.php'; // DB connection

$sql = "SELECT pt.id AS project_id, pt.project_name, 
               COALESCE(sp.status_percentage, 0) AS status_percentage
        FROM project_table pt
        LEFT JOIN (
            SELECT project_id, COUNT(*) AS status_percentage
            FROM status_table
            GROUP BY project_id
        ) sp ON pt.id = sp.project_id";

$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = [
            'project_name' => $row['project_name'],
            'status_percentage' => $row['status_percentage']
        ];
    }
}

echo json_encode(['projects' => $projects]);

?>
