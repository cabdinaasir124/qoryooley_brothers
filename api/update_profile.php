<?php
session_start();
require '../config/conn.php'; // make sure this uses mysqli

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

// Validate old password
if (!empty($old_password)) {
    if (!password_verify($old_password, $user['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Old password is incorrect']);
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match']);
        exit;
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
} else {
    $hashed_password = $user['password'];
}

// Handle profile image
$profile_image = $user['profile_image'];
if (!empty($_FILES['profile_image']['name'])) {
    $img_name = time() . '_' . basename($_FILES['profile_image']['name']);
    $target = "../upload/profile/" . $img_name;

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
        $profile_image = $img_name;
    }
}

// Update user info
$update = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, profile_image = ? WHERE id = ?");
$update->bind_param("ssssi", $username, $email, $hashed_password, $profile_image, $user_id);

if ($update->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
}
?>
