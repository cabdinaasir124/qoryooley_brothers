<?php
require '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
  case 'list':
    // Waxaan muujinaynaa exam_type (schedule) + exam title (exams), laakiin kaydintu waa exam_id
    $sql = "SELECT 
              es.id,
              es.exam_id,
              es.subject_id,
              es.teacher_id,
              es.class_id,
              es.academic_year_id,
              es.exam_date,
              es.max_marks,
              e.title AS exam_title,
              COALESCE(sch.exam_type, 'N/A') AS exam_type,
              s.subject_name,
              t.full_name,
              c.class_name,
              ay.year_name
            FROM exam_subjects es
            JOIN exams e ON es.exam_id = e.id
            LEFT JOIN exam_schedule sch ON sch.exam_id = e.id
            JOIN subjects s ON es.subject_id = s.id
            JOIN teachers t ON es.teacher_id = t.id
            JOIN classes c ON es.class_id = c.id
            JOIN academic_years ay ON es.academic_year_id = ay.id
            ORDER BY es.id DESC";
    $result = $conn->query($sql);
    $data = [];
    if ($result) {
      while($row = $result->fetch_assoc()){
        $data[] = $row;
      }
    }
    echo json_encode($data);
    break;

  case 'get':
    $id = intval($_GET['id'] ?? 0);
    $sql = "SELECT * FROM exam_subjects WHERE id = $id";
    $res = $conn->query($sql);
    echo json_encode($res ? $res->fetch_assoc() : null);
    break;

  case 'save':
    // Inputs
    $id = intval($_POST['id'] ?? 0);
    $exam_id = intval($_POST['exam_id']);
    $subject_id = intval($_POST['subject_id']);
    $teacher_id = intval($_POST['teacher_id']);
    $class_id = intval($_POST['class_id']);
    $academic_year_id = intval($_POST['academic_year_id']);
    $exam_date = $_POST['exam_date'];
    $max_marks = intval($_POST['max_marks']);

    if ($id > 0) {
      // UPDATE
      $stmt = $conn->prepare("UPDATE exam_subjects 
        SET exam_id=?, subject_id=?, teacher_id=?, class_id=?, academic_year_id=?, exam_date=?, max_marks=? 
        WHERE id=?");
      // i i i i i s i i
      $stmt->bind_param("iiiiisii", $exam_id, $subject_id, $teacher_id, $class_id, $academic_year_id, $exam_date, $max_marks, $id);
      $ok = $stmt->execute();
      echo json_encode(['status' => $ok ? 'success' : 'error']);
    } else {
      // INSERT
      $stmt = $conn->prepare("INSERT INTO exam_subjects 
        (exam_id, subject_id, teacher_id, class_id, academic_year_id, exam_date, max_marks) 
        VALUES (?,?,?,?,?,?,?)");
      // i i i i i s i
      $stmt->bind_param("iiiiisi", $exam_id, $subject_id, $teacher_id, $class_id, $academic_year_id, $exam_date, $max_marks);
      $ok = $stmt->execute();
      echo json_encode(['status' => $ok ? 'success' : 'error', 'insert_id' => $ok ? $stmt->insert_id : null]);
    }
    break;

  case 'delete':
    $id = intval($_POST['id'] ?? 0);
    $ok = $conn->query("DELETE FROM exam_subjects WHERE id=$id");
    echo json_encode(['status' => $ok ? 'success' : 'error']);
    break;

  default:
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
}
