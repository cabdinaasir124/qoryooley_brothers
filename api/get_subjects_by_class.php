<?php
include '../config/conn.php';

if (isset($_GET['class_id'])) {
    $class_id = intval($_GET['class_id']);

    // Get subjects for that class
    $stmt = $conn->prepare("SELECT id, subject_name FROM subjects WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);
}
?>
