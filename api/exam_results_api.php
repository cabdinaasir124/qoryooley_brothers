<?php
header('Content-Type: application/json');
include '../config/conn.php';

$action = $_REQUEST['action'] ?? '';

function jdie($msg, $extra = []) {
  echo json_encode(array_merge(['status' => 'error', 'message' => $msg], $extra));
  exit;
}

function jsuccess($dataOrMsg, $data = []) {
  if (is_array($dataOrMsg)) {
    echo json_encode(array_merge(['status' => 'success'], $dataOrMsg));
  } else {
    echo json_encode(['status' => 'success', 'message' => $dataOrMsg] + $data);
  }
  exit;
}

if ($action === 'get_students') {
  $academic_year_id = intval($_GET['academic_year_id'] ?? 0);
  $class_id = intval($_GET['class_id'] ?? 0);
  $exam_id = intval($_GET['exam_id'] ?? 0);
  $subject_id = intval($_GET['subject_id'] ?? 0);

  if (!$academic_year_id || !$class_id || !$exam_id || !$subject_id) {
    jdie("Missing required filters.");
  }

  // 1) Resolve exam_subject_id for this (year + class + exam + subject)
  $sqlES = "
    SELECT id 
    FROM exam_subjects 
    WHERE academic_year_id = $academic_year_id 
      AND class_id = $class_id 
      AND exam_id = $exam_id 
      AND subject_id = $subject_id 
    LIMIT 1
  ";
  $resES = mysqli_query($conn, $sqlES);
  if ($resES === false) jdie("SQL error (exam_subjects): ".mysqli_error($conn));
  $rowES = mysqli_fetch_assoc($resES);
  if (!$rowES) {
    jdie("This subject is not scheduled for the selected exam/class/year. Please add it in Exam Schedule first.");
  }
  $exam_subject_id = intval($rowES['id']);

  // 2) Load students in this class + year
  $sqlStudents = "
    SELECT * 
    FROM students 
    WHERE class_id = $class_id 
      AND academic_year_id = $academic_year_id
    ORDER BY id ASC
  ";
  $resSt = mysqli_query($conn, $sqlStudents);
  if ($resSt === false) jdie("SQL error (students): ".mysqli_error($conn));

  // 3) Preload existing results for these students for this exam_subject
  $existing = [];
  $sqlRes = "
    SELECT student_id, marks_obtained
    FROM exam_results
    WHERE exam_subject_id = $exam_subject_id
  ";
  $resRes = mysqli_query($conn, $sqlRes);
  if ($resRes === false) jdie("SQL error (exam_results): ".mysqli_error($conn));
  while ($r = mysqli_fetch_assoc($resRes)) {
    $existing[intval($r['student_id'])] = $r['marks_obtained'];
  }

  $data = [];
  while ($row = mysqli_fetch_assoc($resSt)) {
    // Try to build student name from common fields
    if (isset($row['name'])) $name = $row['name'];
    elseif (isset($row['full_name'])) $name = $row['full_name'];
    else {
      $first = $row['first_name'] ?? '';
      $last = $row['last_name'] ?? '';
      $name = trim($first.' '.$last);
      if ($name === '') $name = 'Student #'.$row['id'];
    }
    $sid = isset($row['id']) ? intval($row['id']) : intval($row['student_id']);

    $data[] = [
      'student_id' => $sid,
      'name' => $name,
      'existing_marks' => array_key_exists($sid, $existing) ? $existing[$sid] : null
    ];
  }

  jsuccess(['data' => $data]);
}

if ($action === 'save_results') {
  $academic_year_id = intval($_POST['academic_year_id'] ?? 0);
  $class_id = intval($_POST['class_id'] ?? 0);
  $exam_id = intval($_POST['exam_id'] ?? 0);
  $subject_id = intval($_POST['subject_id'] ?? 0);
  $results = json_decode($_POST['results'] ?? '[]', true);

  if (!$academic_year_id || !$class_id || !$exam_id || !$subject_id) {
    jdie("Missing required fields.");
  }
  if (!is_array($results) || count($results) === 0) {
    jdie("No results received.");
  }

  // Resolve exam_subject_id again (safety)
  $sqlES = "
    SELECT id 
    FROM exam_subjects 
    WHERE academic_year_id = $academic_year_id 
      AND class_id = $class_id 
      AND exam_id = $exam_id 
      AND subject_id = $subject_id 
    LIMIT 1
  ";
  $resES = mysqli_query($conn, $sqlES);
  if ($resES === false) jdie("SQL error (exam_subjects): ".mysqli_error($conn));
  $rowES = mysqli_fetch_assoc($resES);
  if (!$rowES) {
    jdie("This subject is not scheduled for the selected exam/class/year. Please add it in Exam Schedule first.");
  }
  $exam_subject_id = intval($rowES['id']);

  foreach ($results as $r) {
    $student_id = intval($r['student_id'] ?? 0);
    $marks = floatval($r['marks'] ?? 0);

    if (!$student_id && $student_id !== 0) continue;

    // Upsert manually
    $checkSQL = "SELECT id FROM exam_results WHERE student_id=$student_id AND exam_subject_id=$exam_subject_id LIMIT 1";
    $checkRes = mysqli_query($conn, $checkSQL);
    if ($checkRes === false) jdie("SQL error (exam_results check): ".mysqli_error($conn));
    if (mysqli_num_rows($checkRes) > 0) {
      $row = mysqli_fetch_assoc($checkRes);
      $rid = intval($row['id']);
      $upd = mysqli_query($conn, "UPDATE exam_results SET marks_obtained=$marks WHERE id=$rid");
      if ($upd === false) jdie("Update failed for student $student_id: ".mysqli_error($conn));
    } else {
      $ins = mysqli_query($conn, "INSERT INTO exam_results (student_id, exam_subject_id, marks_obtained) VALUES ($student_id, $exam_subject_id, $marks)");
      if ($ins === false) jdie("Insert failed for student $student_id: ".mysqli_error($conn));
    }
  }

  jsuccess("Results saved successfully!");
}


jdie("Invalid action.");
