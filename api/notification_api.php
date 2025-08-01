<?php
include '../config/conn.php';
session_start();
header('Content-Type: application/json');

$role = $_GET['role'] ?? '';
$user_id = $_SESSION['user_id'] ?? 0;

$notifications = [];

if (!empty($role) && $user_id) {
    $sql = "SELECT n.id, n.title, n.body, n.created_at, u.username, u.profile_image
            FROM announcements n
            JOIN users u ON n.posted_by = u.id
            WHERE (n.target_audience = ? OR n.target_audience = 'all')
              AND n.id NOT IN (
                  SELECT announcement_id FROM announcement_reads WHERE user_id = ?
              )
            ORDER BY n.created_at DESC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $role, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

echo json_encode($notifications);
