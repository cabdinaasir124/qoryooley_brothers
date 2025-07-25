<?php
require_once '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

function respond($success, $message = '', $data = []) {
  echo json_encode(compact('success', 'message', 'data'));
  exit;
}

if ($action === 'create') {
  $stmt = $conn->prepare("INSERT INTO subjects (subject_name, subject_code, class_id, academic_year_id, description, status) VALUES (?, ?, ?, ?, ?, ?)");
  if (!$stmt) respond(false, "Prepare failed: " . $conn->error);
  $stmt->bind_param("ssiiss", $_POST['subject_name'], $_POST['subject_code'], $_POST['class_id'], $_POST['academic_year_id'], $_POST['description'], $_POST['status']);
  $stmt->execute() ? respond(true, "Subject created.") : respond(false, "Create failed: " . $stmt->error);
}

elseif ($action === 'read') {
  $id = $_GET['id'] ?? 0;
  $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $data = $res->fetch_assoc();
  $data ? respond(true, "Fetched.", $data) : respond(false, "Not found.");
}

elseif ($action === 'update') {
  $stmt = $conn->prepare("UPDATE subjects SET subject_name=?, subject_code=?, class_id=?, description=?, status=? WHERE id=?");
  $stmt->bind_param("ssiisi", $_POST['subject_name'], $_POST['subject_code'], $_POST['class_id'], $_POST['description'], $_POST['status'], $_POST['id']);
  $stmt->execute() ? respond(true, "Subject updated.") : respond(false, "Update failed: " . $stmt->error);
}

elseif ($action === 'delete') {
  $id = $_POST['id'] ?? 0;
  $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute() ? respond(true, "Deleted.") : respond(false, "Delete failed.");
}

elseif ($action === 'list') {
  $academic_year_id = $_GET['academic_year_id'] ?? 0;
  $sql = "SELECT s.*, c.class_name FROM subjects s
          LEFT JOIN classes c ON s.class_id = c.id
          WHERE s.academic_year_id = ?
          ORDER BY s.id DESC";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $academic_year_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $data = [];
  while ($row = $res->fetch_assoc()) $data[] = $row;
  respond(true, "Subjects fetched.", $data);
}

else {
  respond(false, "Invalid action.");
}
