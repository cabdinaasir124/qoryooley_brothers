<?php
include '../config/conn.php';
header('Content-Type: application/json');
$action = $_GET['action'] ?? '';

if ($action === 'get_students') {
    // Fetch only Quranic department students
    $stmt = $conn->prepare("
        SELECT id, full_name AS name
        FROM students
        WHERE department_type = 'quranic'
        ORDER BY full_name
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

elseif ($action === 'get_hifz') {
    // Fetch Hifz progress with student name
    $sql = "
        SELECT h.*, s.full_name AS student_name
        FROM hifz_progress h
        JOIN students s ON h.student_id = s.id
        ORDER BY h.id DESC
    ";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

elseif ($action === 'add_hifz') {
    $student_id  = $_POST['student_id'];
    $juz         = $_POST['juz_completed'];
    $last_surah  = $_POST['last_surah'];
    $revision    = $_POST['revision_notes'];

    // Insert into hifz_progress
    $stmt = $conn->prepare("
        INSERT INTO hifz_progress (student_id, juz_completed, last_surah, revision_notes)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("iiss", $student_id, $juz, $last_surah, $revision);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
}
