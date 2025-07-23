<?php
// Set JSON response header
header("Content-Type: application/json");

// Include database connection
require_once '../config/conn.php';

// Helper function to send JSON response
function send_response($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_response(false, 'Invalid request method.');
}

if (!isset($_POST['action']) || $_POST['action'] !== 'add_user') {
    send_response(false, 'Invalid or missing action.');
}

// Check and sanitize required fields
$required_fields = ['username', 'email', 'password', 'role', 'status'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        send_response(false, "Missing required field: $field");
    }
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
$role = trim($_POST['role']);
$status = trim($_POST['status']);

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    send_response(false, 'Database statement preparation failed.');
    echo json_encode([
    'success' => false,
    'message' => 'Database statement preparation failed: ' . $conn->error
]);

}

$stmt->bind_param("sssss", $username, $email, $password, $role, $status);

// Execute and return response
if ($stmt->execute()) {
    send_response(true, 'User added successfully.');
} else {
    send_response(false, 'Database execution failed.');
    echo json_encode([
    'success' => false,
    'message' => 'Database execution failed: ' . $stmt->error
]);

}



$stmt->close();
$conn->close();
?>
