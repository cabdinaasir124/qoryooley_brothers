<?php
require_once '../config/conn.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
  case 'fetch':
    $academic_year_id = $_GET['academic_year_id'] ?? 0;
    $class_id = $_GET['class_id'] ?? null;

    if ($class_id) {
      $stmt = $conn->prepare("SELECT s.*, c.class_name, sub.subject_name 
                              FROM schedules s
                              JOIN classes c ON s.class_id = c.id
                              JOIN subjects sub ON s.subject_id = sub.id
                              WHERE s.academic_year_id = ? AND s.class_id = ?");
      $stmt->bind_param("ii", $academic_year_id, $class_id);
    } else {
      $stmt = $conn->prepare("SELECT s.*, c.class_name, sub.subject_name 
                              FROM schedules s
                              JOIN classes c ON s.class_id = c.id
                              JOIN subjects sub ON s.subject_id = sub.id
                              WHERE s.academic_year_id = ?");
      $stmt->bind_param("i", $academic_year_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $data]);
    break;

  case 'save':
    $id = $_POST['id'] ?? null;
    $academic_year_id = $_POST['academic_year_id'];
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $day = $_POST['day_of_week'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $teacher = $_POST['teacher_name'];
    $room = $_POST['room'];
    $status = $_POST['status'];

    if (empty($academic_year_id) || empty($class_id) || empty($subject_id) || empty($day) || empty($start) || empty($end) || empty($teacher)) {
      echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
      exit;
    }

    if ($id) {
      // Update
      $stmt = $conn->prepare("UPDATE schedules 
                              SET academic_year_id=?, class_id=?, subject_id=?, day_of_week=?, start_time=?, end_time=?, teacher_name=?, room=?, status=? 
                              WHERE id=?");
      $stmt->bind_param("iiissssssi", $academic_year_id, $class_id, $subject_id, $day, $start, $end, $teacher, $room, $status, $id);
      $stmt->execute();
      echo json_encode(['status' => 'success', 'message' => 'Schedule updated']);
    } else {
      // Insert
      $stmt = $conn->prepare("INSERT INTO schedules 
                              (academic_year_id, class_id, subject_id, day_of_week, start_time, end_time, teacher_name, room, status) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("iiissssss", $academic_year_id, $class_id, $subject_id, $day, $start, $end, $teacher, $room, $status);
      $stmt->execute();
      echo json_encode(['status' => 'success', 'message' => 'Schedule added']);
    }
    break;

  case 'delete':
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM schedules WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['status' => 'success', 'message' => 'Schedule deleted']);
    break;

  case 'get':
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM schedules WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $result]);
    break;

  default:
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    break;
}
?>
