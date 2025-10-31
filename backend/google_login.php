<?php
// Start output buffering
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS headers
header("Access-Control-Allow-Origin: http://localhost:3002");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

// Handle OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    ob_end_flush();
    exit();
}

// Verify it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    ob_end_flush();
    exit();
}

// Verify content type
if (!isset($_SERVER['CONTENT_TYPE']) || stripos($_SERVER['CONTENT_TYPE'], 'application/json') === false) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Content-Type must be application/json']);
    ob_end_flush();
    exit();
}

// Include required files
require_once __DIR__ . '/src/Client.php';
require_once __DIR__ . '/src/Service/Exception.php';
include "config.php";

// Check DB connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    ob_end_flush();
    exit();
}

// Get and decode JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    ob_end_flush();
    exit();
}

// Validate credential
if (!isset($data['credential']) || empty($data['credential'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing Google credential']);
    ob_end_flush();
    exit();
}

$id_token = $data['credential'];
$google_client_id = '910635849979-cohqci9jcn8mjcp7nbsrcdl7tf2ailqb.apps.googleusercontent.com';

try {
    $client = new Google_Client(['client_id' => $google_client_id]);
    $payload = $client->verifyIdToken($id_token);

    if (!$payload) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid Google ID token']);
        ob_end_flush();
        exit();
    }

    $email = $payload['email'];
    $name = $payload['name'] ?? $email;

    // Check if user exists
    $query = "SELECT id, name, email, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception('Database prepare failed: ' . $conn->error);
    }

    if (!$stmt->bind_param("s", $email) || !$stmt->execute()) {
        throw new Exception('Database query failed: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response = [
            'status' => 'success',
            'data' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ];
    } else {
        // Register new user
        $default_role = 'teamlead';
        $dummy_password = bin2hex(random_bytes(16));
        $password_hash = password_hash($dummy_password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        
        if (!$insert_stmt) {
            throw new Exception('Database prepare failed: ' . $conn->error);
        }

        if (!$insert_stmt->bind_param("ssss", $name, $email, $password_hash, $default_role) || !$insert_stmt->execute()) {
            throw new Exception('Database insert failed: ' . $insert_stmt->error);
        }

        $response = [
            'status' => 'success',
            'data' => [
                'id' => $conn->insert_id,
                'name' => $name,
                'email' => $email,
                'role' => $default_role
            ]
        ];
    }

    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
} finally {
    $conn->close();
    ob_end_flush();
}
?>