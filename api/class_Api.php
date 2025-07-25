<?php
header("Content-Type: application/json");
session_start();
require_once("../config/conn.php");

$response = ['status' => 'error', 'message' => 'Unknown error occurred.'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Detect Insert vs Update
    $id = intval($_POST['id'] ?? 0);
    $className = trim($_POST['class_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $maxStudents = intval($_POST['max_students'] ?? 0);
    $daysActive = $_POST['days_active'] ?? [];
    $status = trim($_POST['status'] ?? '');

    if ($className === '' || $maxStudents <= 0 || $status === '') {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    $academicYearId = intval($_POST['academic_year_id'] ?? 0);

if ($academicYearId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Academic year is required.']);
    exit;
}


    $daysActiveJson = json_encode($daysActive);

    if ($id > 0) {
        // 🔁 UPDATE
        $stmt = $conn->prepare("UPDATE classes SET class_name = ?, description = ?, max_students = ?, days_active = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssissi", $className, $description, $maxStudents, $daysActiveJson, $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Class updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        // ➕ INSERT
        $stmt = $conn->prepare("INSERT INTO classes (class_name, description, max_students, days_active, status, academic_year_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissi", $className, $description, $maxStudents, $daysActiveJson, $status, $academicYearId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Class added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $conn->close();
    exit;
}

if ($requestMethod === 'GET') {
    // READ ALL or SINGLE
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        if ($row = $result->fetch_assoc()) {
            $row['days_active'] = json_decode($row['days_active'], true);
            $data[] = $row;
        }

        echo json_encode(['status' => 'success', 'data' => $data]);
        $stmt->close();
    } 
    else {
    $classes = [];
    if (isset($_GET['academic_year_id']) && is_numeric($_GET['academic_year_id'])) {
        $yearId = intval($_GET['academic_year_id']);
        $stmt = $conn->prepare("SELECT * FROM classes WHERE academic_year_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $yearId);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM classes ORDER BY id DESC");
    }

    while ($row = $result->fetch_assoc()) {
        $row['days_active'] = json_decode($row['days_active'], true);
        $classes[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $classes]);
}


    $conn->close();
    exit;
}

if ($requestMethod === 'DELETE') {
    // DELETE
    parse_str(file_get_contents("php://input"), $deleteData);
    $id = intval($deleteData['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Class deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Delete failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Fallback
echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
exit;
?>
