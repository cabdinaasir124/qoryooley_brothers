<?php
include '../config/conn.php';
$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    $academic_year_id = intval($_GET['academic_year_id'] ?? 0);

    $where = '';
    if ($academic_year_id > 0) {
        $where = "WHERE s.academic_year_id = $academic_year_id";
    }

    $query = "
        SELECT s.*, c.class_name, p.name AS parent_name 
        FROM students s
        LEFT JOIN classes c ON s.class_id = c.id
        LEFT JOIN parents p ON s.parent_id = p.id
        $where
        ORDER BY s.id DESC
    ";

    $result = $conn->query($query);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    exit;
}

if ($action === 'generate_id') {
    $academic_year_id = intval($_GET['academic_year_id'] ?? 0);

    // 1. Get the year name (format: 2025/2030) from academic_years
    $yearResult = $conn->query("SELECT year_name FROM academic_years WHERE id = $academic_year_id LIMIT 1");

    if ($yearResult && $yearResult->num_rows > 0) {
        $yearRow = $yearResult->fetch_assoc();
        $yearName = $yearRow['year_name']; // e.g., "2025/2030"

        // 2. Split the year_name into start and end
        $years = explode('/', $yearName);
        $start = substr(trim($years[0]), -2); // "25"
        $end = isset($years[1]) ? substr(trim($years[1]), -2) : $start; // "30" or "25"

        $prefix = "QBS-$start$end-"; // e.g., QBS-2530-
    } else {
        echo json_encode(['student_id' => '', 'error' => 'Invalid academic year']);
        exit;
    }

    // 3. Get latest student_id with same prefix
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id LIKE CONCAT(?, '%') ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $prefix);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastIdNumber = intval(substr($row['student_id'], strlen($prefix)));
        $newIdNumber = $lastIdNumber + 1;
    } else {
        $newIdNumber = 1;
    }

    // 4. Pad the number and return full ID
    $studentId = $prefix . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);

    echo json_encode(['student_id' => $studentId]);
    exit;
}



if ($action === 'create' || $action === 'update') {
    $isUpdate = $action === 'update';
    $id = $_POST['id'] ?? null;
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['date_of_birth'];
    $pob = $_POST['place_of_birth'];
    $address = $_POST['address'];
    $class_id = intval($_POST['class_id']);
    $academic_year_id = intval($_POST['academic_year_id']);
    $parent_id = intval($_POST['parent_id']);
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $imagePath = '';
    if (!empty($_FILES['student_image']['name'])) {
        $uploadDir = '../upload/students/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = uniqid() . '_' . basename($_FILES['student_image']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['student_image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    if ($isUpdate) {
        $stmt = $conn->prepare("UPDATE students SET full_name=?, gender=?, date_of_birth=?, place_of_birth=?, address=?, class_id=?, academic_year_id=?, parent_id=?, status=?, notes=? WHERE id=?");
        $stmt->bind_param("sssssiiissi", $full_name, $gender, $dob, $pob, $address, $class_id, $academic_year_id, $parent_id, $status, $notes, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, gender, date_of_birth, place_of_birth, address, class_id, academic_year_id, parent_id, status, notes, student_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssiiisss", $student_id, $full_name, $gender, $dob, $pob, $address, $class_id, $academic_year_id, $parent_id, $status, $notes, $imagePath);
    }

    echo json_encode(['status' => $stmt->execute() ? 'success' : 'error', 'message' => $stmt->error]);
    exit;
}

if ($action === 'delete') {
    $student_id = $_POST['student_id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    echo json_encode(['status' => $stmt->execute() ? 'deleted' : 'error', 'message' => $stmt->error]);
    exit;
}

if ($action === 'get') {
    $id = intval($_GET['id']);
    $query = "
        SELECT s.*, c.class_name, p.name AS parent_name 
        FROM students s
        LEFT JOIN classes c ON s.class_id = c.id
        LEFT JOIN parents p ON s.parent_id = p.id
        WHERE s.id = $id
    ";
    $result = $conn->query($query);
    echo json_encode($result->fetch_assoc());
    exit;
}


if ($action === 'dashboard_counts') {
    $counts = [
        'students' => 0,
        'classes' => 0,
    ];

    // Count students
    $studentRes = $conn->query("SELECT COUNT(*) AS total FROM students");
    if ($studentRes) {
        $counts['students'] = $studentRes->fetch_assoc()['total'];
    }

    // Count active classes (assuming a column `status` = 'Active')
    $classRes = $conn->query("SELECT COUNT(*) AS total FROM classes WHERE status = 'ongoing'");
    if ($classRes) {
        $counts['classes'] = $classRes->fetch_assoc()['total'];
    }

    echo json_encode($counts);
    exit;
}



echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
