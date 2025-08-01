<?php
header('Content-Type: application/json');
include '../config/conn.php';

if (!isset($_GET['class_name']) || empty($_GET['class_name'])) {
    echo json_encode([]);
    exit;
}

// Get class ID by class_name
$class_name = mysqli_real_escape_string($conn, $_GET['class_name']);
$class_sql = "SELECT id FROM classes WHERE class_name = '$class_name'";
$class_result = mysqli_query($conn, $class_sql);

if (!$class_result || mysqli_num_rows($class_result) == 0) {
    echo json_encode([]);
    exit;
}

$class_data = mysqli_fetch_assoc($class_result);
$class_id = $class_data['id'];

// Get students with this class_id
$student_sql = "SELECT id, full_name FROM students WHERE class_id = '$class_id'";
$student_result = mysqli_query($conn, $student_sql);

$students = [];
while ($row = mysqli_fetch_assoc($student_result)) {
    $students[] = $row;
}

echo json_encode($students);
