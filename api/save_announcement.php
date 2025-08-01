<?php
include '../config/conn.php';
session_start();

$title = $_POST['title'];
$body = $_POST['body'];
$type = $_POST['type'];
$target = $_POST['target_audience'] ?? 'all';
$allowed_targets = ['student', 'teachers', 'parents', 'admin', 'all'];
if (!in_array($target, $allowed_targets)) {
    $target = 'all'; // fallback
}


// Get user ID from session
$posted_by = $_SESSION['user_id'] ?? null;

if (!$posted_by) {
    die("Error: No user is logged in.");
}

$sql = "INSERT INTO announcements (title, body, type, target_audience, posted_by)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $title, $body, $type, $target, $posted_by); // 'i' = integer

if ($stmt->execute()) {
    header("Location: ../admin/announcements.php?msg=success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
