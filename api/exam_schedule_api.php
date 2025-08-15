<?php
include '../config/conn.php';
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if($action === 'list') {
    $class_filter = intval($_GET['class_filter'] ?? 0);
    $exam_type_filter = $_GET['exam_type_filter'] ?? '';
    $academic_year_filter = intval($_GET['academic_year_filter'] ?? 0);

    $sql = "SELECT es.exam_id, s.subject_name, c.class_name, ay.year_name, es.exam_date, es.exam_type, es.exam_start_time, es.exam_end_time
            FROM exam_schedule es
            JOIN subjects s ON es.subject_id = s.id
            JOIN classes c ON es.class_id = c.id
            JOIN academic_years ay ON es.academic_year_id = ay.id
            WHERE 1";

    if($class_filter > 0) $sql .= " AND es.class_id = $class_filter";
    if(!empty($exam_type_filter)) $sql .= " AND es.exam_type = '".$conn->real_escape_string($exam_type_filter)."'";
    if($academic_year_filter > 0) $sql .= " AND es.academic_year_id = $academic_year_filter";

    $result = $conn->query($sql);
    $rows = [];
    while($row = $result->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows);
    exit;
}

if($action === 'get'){
    $id = intval($_GET['id'] ?? 0);
    $row = $conn->query("SELECT * FROM exam_schedule WHERE exam_id = $id")->fetch_assoc();
    echo json_encode($row);
    exit;
}

if($action === 'save'){
    $id = intval($_POST['id'] ?? 0);
    $subject_id = intval($_POST['subject_id']);
    $class_id = intval($_POST['class_id']);
    $academic_year_id = intval($_POST['academic_year_id']);
    $exam_date = $_POST['exam_date'];
    $exam_type = $_POST['exam_type'];
    $exam_start_time = $_POST['exam_start_time'];
    $exam_end_time = $_POST['exam_end_time'];

    if($id > 0){
        $stmt = $conn->prepare("UPDATE exam_schedule SET subject_id=?, class_id=?, academic_year_id=?, exam_date=?, exam_type=?, exam_start_time=?, exam_end_time=? WHERE exam_id=?");
        $stmt->bind_param("iiissssi",$subject_id,$class_id,$academic_year_id,$exam_date,$exam_type,$exam_start_time,$exam_end_time,$id);
    }else{
        $stmt = $conn->prepare("INSERT INTO exam_schedule (subject_id,class_id,academic_year_id,exam_date,exam_type,exam_start_time,exam_end_time) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("iiissss",$subject_id,$class_id,$academic_year_id,$exam_date,$exam_type,$exam_start_time,$exam_end_time);
    }

    $success = $stmt->execute();
    echo json_encode(['status'=>$success?'success':'error']);
    exit;
}

if($action === 'delete'){
    $id = intval($_POST['id'] ?? 0);
    $success = $conn->query("DELETE FROM exam_schedule WHERE exam_id = $id");
    echo json_encode(['status'=>$success?'success':'error']);
    exit;
}

echo json_encode(['status'=>'error','message'=>'Invalid action']);
