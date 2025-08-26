<?php
header('Content-Type: application/json');
include '../config/conn.php';

$action = $_GET['action'] ?? '';

if ($action === 'fetch_results') {
    $class_id = intval($_GET['class_id'] ?? 0);
    $student_name = $_GET['student_name'] ?? '';
    $exam_type = $_GET['exam_type'] ?? ''; // ✅ Pass "Mid-Term" or "Final"

    $query = "
    SELECT 
        st.id AS student_id,
        st.full_name AS student_name,
        c.class_name,
        e.term AS exam_name,
        SUM(er.marks_obtained) AS total_obtained,
        SUM(es.max_marks) AS total_marks
    FROM students st
    INNER JOIN classes c ON st.class_id = c.id
    INNER JOIN exam_results er ON st.id = er.student_id
    INNER JOIN exam_subjects es ON er.exam_subject_id = es.id
    INNER JOIN exams e ON es.exam_id = e.id
    WHERE 1=1
";

    if ($class_id > 0) $query .= " AND st.class_id = $class_id";
    if (!empty($student_name)) {
        $student_name_safe = $conn->real_escape_string($student_name);
        $query .= " AND st.full_name LIKE '%$student_name_safe%'";
    }
    if (!empty($exam_type)) {
        $exam_type_safe = $conn->real_escape_string($exam_type);
        $query .= " AND e.term = '$exam_type_safe'";
    }

    // ✅ group by student only (not exam, since you want one type)
    $query .= " GROUP BY st.id, st.full_name, c.class_name
                ORDER BY st.class_id, st.full_name";

    $result = $conn->query($query);
    if (!$result) { echo json_encode(["error" => $conn->error]); exit; }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $percentage = round(($row['total_obtained'] / $row['total_marks']) * 100, 2);
        $grade = $percentage >= 90 ? 'A+' :
                ($percentage >= 80 ? 'A' :
                ($percentage >= 70 ? 'B+' :
                ($percentage >= 60 ? 'B' :
                ($percentage >= 50 ? 'C' : 'F'))));

        $data[] = [
            "student_id"    => $row['student_id'],
            "student_name"  => $row['student_name'],
            "class_name"    => $row['class_name'],
            "exam_name"     => $row['exam_name'], // ✅ Only the one exam type
            "marks_obtained"=> $row['total_obtained'],
            "total_marks"   => $row['total_marks'],
            "percentage"    => $percentage,
            "grade"         => $grade
        ];
    }

    echo json_encode($data);
    exit;
}
