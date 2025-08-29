<?php 
require("../config/conn.php");
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if($action === 'all_students'){
  header('Content-Type: application/json');
  $select=mysqli_query($conn, "SELECT * FROM `students`");
  if($select && mysqli_num_rows($select)>0){
    $row=mysqli_fetch_assoc($select);
    echo json_encode(['status'=>'success','message'=>mysqli_num_rows($select)]);
  }else{
    echo json_encode(['status'=>'error','message'=>'No student Found it!']);

  }
}elseif($action === 'allattendence'){
     header('Content-Type: application/json');
     $readatt=mysqli_query($conn,"SELECT * FROM `attendance`");
     if($readatt && mysqli_num_rows($readatt)>0){
        $row=mysqli_fetch_assoc($readatt);
        echo json_encode(['status'=>'success','message'=>mysqli_num_rows($readatt)]);
     }else{
        echo json_encode(['status'=>'error','message'=>'No Attendence Found it!']);
     }
}elseif($action === 'All_exam'){
    header('Content-Type: application/json');
    $readExam=mysqli_query($conn,"SELECT * FROM `exams`");
    if($readExam && mysqli_num_rows($readExam)>0){
        $row=mysqli_fetch_assoc($readExam);
        echo json_encode(['status'=>'success','message'=>mysqli_num_rows($readExam)]);
    }else{
        echo json_encode(['status'=>'arror','message'=>'No Exam Found it!']);

    }
}elseif($action === 'class_total'){
    header('Content-Type: application/json');
    $readclass=mysqli_query($conn,"SELECT * FROM `classes`");
    if($readclass && mysqli_num_rows($readclass)>0){
        $row=mysqli_fetch_assoc($readclass);
        echo json_encode(['status'=>'success','message'=>mysqli_num_rows($readclass)]);
    }else{
        echo json_encode(['status'=>'arror','message'=>'No class Found it!']);

    }
}elseif($action === 'Allteachers'){
    header('Content-Type: application/json');
    // Query upcoming exams
    $readTeachers=mysqli_query($conn,"SELECT * FROM `teachers`");
    if($readTeachers && mysqli_num_rows($readTeachers)>0){
        $row=mysqli_fetch_assoc($readTeachers);
        echo json_encode(['status'=>'success','message'=>mysqli_num_rows($readTeachers)]);
    }else{
         echo json_encode(['status'=>'arror','message'=>'No teacher Found it!']);
    }
}elseif($action === 'published_exams'){
    header('Content-Type: application/json');

    $published_exams = 0;
    $upcoming_exams  = 0;
    $total_exams     = 0;
    $progress        = 0;

    // Published exams (xitaa haddii waqtigooda aan la gaarin)
$published_query = "SELECT COUNT(*) AS published_count FROM exams WHERE status='Published'";
    $published_result = mysqli_query($conn, $published_query);
    if ($published_result) {
        $published_row = mysqli_fetch_assoc($published_result);
        $published_exams = (int)$published_row['published_count'];
    }

    // Upcoming exams (kuwa la publish gareeyay oo waqtigooda weli imaanin)
$upcoming_query  = "SELECT COUNT(*) AS upcoming_count FROM exams WHERE status='Published' AND date >= CURDATE()";
    $upcoming_result = mysqli_query($conn, $upcoming_query);
    if ($upcoming_result) {
        $upcoming_row = mysqli_fetch_assoc($upcoming_result);
        $upcoming_exams = (int)$upcoming_row['upcoming_count'];
    }

    // Wadarta exams (published + draft labadaba)
    $total_query = "SELECT COUNT(*) AS total_exams FROM exams";
    $total_result = mysqli_query($conn, $total_query);
    if ($total_result) {
        $total_row = mysqli_fetch_assoc($total_result);
        $total_exams = (int)$total_row['total_exams'];
    }

    // Progress = upcoming imtixaanada la sugayo marka la barbar dhigo total-ka exams
    $progress = ($total_exams > 0 && $upcoming_exams > 0)
                ? round(($upcoming_exams / $total_exams) * 100)
                : 0;

    echo json_encode([
        'published' => $published_exams,
        'upcoming'  => $upcoming_exams,
        'total'     => $total_exams,
        'progress'  => $progress
    ]);
}



?>