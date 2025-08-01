<?php
// ../api/exam_create_process.php
include '../config/conn.php';
session_start();

$title     = $_POST['title'];
$date      = $_POST['date'];
$term      = $_POST['term'];
$status    = $_POST['status'];
$academic_year_id = $_POST['academic_year_id'];
$class_ids = $_POST['class_ids'] ?? []; // multiple class IDs
$posted_by = $_SESSION['user_id'] ?? null;

$response = ['status' => 'error', 'message' => 'Something went wrong.'];

if (!$posted_by || empty($class_ids)) {
  echo json_encode($response);
  exit;
}

$stmt = $conn->prepare("INSERT INTO exams (title, date, term, status, class_id, academic_year_id) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($class_ids as $class_id) {
  $stmt->bind_param("ssssii", $title, $date, $term, $status, $class_id, $academic_year_id);
  $stmt->execute();
}

// Insert into announcements
$body = "New exam titled '$title' has been scheduled for term '$term' on $date.";
$target = 'student';
$type = 'school';

$ann = $conn->prepare("INSERT INTO announcements (title, body, type, target_audience, posted_by) VALUES (?, ?, ?, ?, ?)");
$ann->bind_param("sssss", $title, $body, $type, $target, $posted_by);
$ann->execute();

$response = ['status' => 'success', 'message' => 'Exam(s) created and notification sent.'];
echo json_encode($response);
