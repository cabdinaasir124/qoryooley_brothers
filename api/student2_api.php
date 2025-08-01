<?php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action == 'all') {
    $query = "SELECT s.id, s.full_name, c.class_name FROM students s JOIN classes c ON s.class_id = c.id ORDER BY s.full_name ASC";
    $result = mysqli_query($conn, $query);
    $students = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    echo json_encode($students);
}

if ($action == 'details' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT s.student_id, s.full_name, c.class_name 
              FROM students s 
              JOIN classes c ON s.class_id = c.id 
              WHERE s.id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Student not found']);
    }
}
