<?php
include '../config/conn.php';

$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    // Fetch all students with related class and parent info
    $query = "
        SELECT s.*, c.class_name, p.name AS parent_name 
        FROM students s
        LEFT JOIN classes c ON s.class_id = c.id
        LEFT JOIN parents p ON s.parent_id = p.id
        ORDER BY s.id DESC
    ";
    $result = $conn->query($query);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
    exit;
}

if ($action === 'generate_id') {
    // Generate next student ID like QBS-001
    $result = $conn->query("SELECT MAX(id) AS max_id FROM students");
    $row = $result->fetch_assoc();
    $nextId = $row['max_id'] + 1;
    $studentId = 'QBS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    echo json_encode(['student_id' => $studentId]);
    exit;
}

if ($action === 'create') {
    // Receive student data
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $place_of_birth = $_POST['place_of_birth'];
    $address = $_POST['address'];
    $class_id = intval($_POST['class_id']);
    $academic_year_id = intval($_POST['academic_year_id']);
    $parent_id = intval($_POST['parent_id']);
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    // Upload image if exists
    $imagePath = '';
    if (!empty($_FILES['student_image']['name'])) {
        $uploadDir = '../upload/students/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create folder if it doesn't exist
        }

        $filename = uniqid() . '_' . basename($_FILES['student_image']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['student_image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Insert student into DB
    $stmt = $conn->prepare("
        INSERT INTO students 
        (student_id, full_name, gender, date_of_birth, place_of_birth, address, class_id, academic_year_id, parent_id, status, notes, student_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssssiiisss",
        $student_id,
        $full_name,
        $gender,
        $date_of_birth,
        $place_of_birth,
        $address,
        $class_id,
        $academic_year_id,
        $parent_id,
        $status,
        $notes,
        $imagePath
    );

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit;
}

// Unknown action
echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
?>
