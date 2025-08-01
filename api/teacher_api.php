<?php
// 📁 File: api/teacher_api.php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'get_teachers') {
    $sql = "SELECT t.*, c.class_name FROM teachers t LEFT JOIN classes c ON t.class_id = c.id ORDER BY t.id DESC";
    $res = mysqli_query($conn, $sql);

    $teachers = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $teachers[] = [
            'id' => $row['id'],
            'teacher_code' => $row['teacher_code'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'qualification' => $row['qualification'],
            'salary' => $row['salary'],
            'class_name' => $row['class_name'] ?? 'N/A'
        ];
    }
    echo json_encode(['status' => 'success', 'data' => $teachers]);
    exit;

} elseif ($action === 'get_classes') {
    $res = mysqli_query($conn, "SELECT id, class_name FROM classes");
    $classes = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $classes[] = [
            'id' => $row['id'],
            'class_name' => $row['class_name']
        ];
    }
    echo json_encode(['status' => 'success', 'data' => $classes]);
    exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save_teacher') {
    $teacher_code = mysqli_real_escape_string($conn, $_POST['teacher_code']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $salary = floatval($_POST['salary']);
    $class_id = intval($_POST['class_id']);

    $sql = "INSERT INTO teachers (teacher_code, full_name, email, phone, qualification, salary, class_id)
            VALUES ('$teacher_code', '$full_name', '$email', '$phone', '$qualification', $salary, $class_id)";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Teacher saved successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save teacher.']);
    }
    exit;
}

// Fallback
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>