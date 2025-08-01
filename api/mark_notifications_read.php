<?php
include '../config/conn.php';
session_start();
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id) {
    $sql = "INSERT IGNORE INTO announcement_reads (announcement_id, user_id)
            SELECT id, ? FROM announcements";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
}
