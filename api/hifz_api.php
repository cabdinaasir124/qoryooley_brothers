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
}elseif($action === 'delete_hifz'){
    $id = intval($_POST['id']);

    $delete = "DELETE FROM `hifz_progress` WHERE id = '$id'";
    $query = mysqli_query($conn, $delete);

    if($query){
        echo json_encode([
            'success' => true,
            'message' => 'Successfully Deleted!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed To Delete!'
        ]);
    }
}elseif($action === "edit-hifz"){
    $id = intval($_POST['id']);
    $edit = "
        SELECT h.*, s.full_name AS student_name
        FROM hifz_progress h
        JOIN students s ON h.student_id = s.id
        WHERE h.id = '$id'
    ";
    $query = mysqli_query($conn, $edit);

    if($query && mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
    }
}elseif($action === "update_hifz"){
    $id         = intval($_POST['id']);
    $student_id = $_POST['student_id'];
    $juz        = $_POST['juz_completed'];
    $last_surah = $_POST['last_surah'];
    $revision   = $_POST['revision_notes'];

    $update = "
        UPDATE `hifz_progress`
        SET 
            `student_id` = '$student_id',
            `juz_completed` = '$juz',
            `last_surah` = '$last_surah',
            `revision_notes` = '$revision'
        WHERE id = '$id'
    ";
    
    $query = mysqli_query($conn, $update);
    if($query){
        echo json_encode(['status'=>'success','message'=>'Successfully Updated!']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Failed To Update Hifz!']);
    }
}




