<?php
header('Content-Type: application/json');
require_once '../config/conn.php'; // adjust path if needed

function response($data, $status_code = 200) {
    http_response_code($status_code);
    echo json_encode($data);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    // ================= FETCH ALL HALAQAS =================
    case 'fetch':
        $sql = "SELECT * FROM halaqa_schedule ORDER BY FIELD(day, 
                'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'), time ASC";
        $result = $conn->query($sql);
        $halaqas = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $halaqas[] = $row;
            }
        }
        response($halaqas);
        break;

    // ================= CREATE HALAQA =================
    case 'create':
        $day = $_POST['day'] ?? '';
        $time = $_POST['time'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $teacher = $_POST['teacher'] ?? '';

        if (!$day || !$time || !$subject || !$teacher) {
            response(['status' => 'error', 'message' => 'All fields are required'], 400);
        }

        $stmt = $conn->prepare("INSERT INTO halaqa_schedule (day, time, subject, teacher) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $day, $time, $subject, $teacher);
        if ($stmt->execute()) {
            response(['status' => 'success', 'message' => 'Halaqa added successfully']);
        } else {
            response(['status' => 'error', 'message' => 'Failed to add halaqa'], 500);
        }
        break;

    // ================= UPDATE HALAQA =================
    case 'update':
        $id = intval($_POST['id'] ?? 0);
        $day = $_POST['day'] ?? '';
        $time = $_POST['time'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $teacher = $_POST['teacher'] ?? '';

        if ($id <= 0 || !$day || !$time || !$subject || !$teacher) {
            response(['status' => 'error', 'message' => 'All fields are required'], 400);
        }

        $stmt = $conn->prepare("UPDATE halaqa_schedule SET day=?, time=?, subject=?, teacher=? WHERE id=?");
        $stmt->bind_param("ssssi", $day, $time, $subject, $teacher, $id);
        if ($stmt->execute()) {
            response(['status' => 'success', 'message' => 'Halaqa updated successfully']);
        } else {
            response(['status' => 'error', 'message' => 'Failed to update halaqa'], 500);
        }
        break;

    // ================= DELETE HALAQA =================
    case 'delete':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            response(['status' => 'error', 'message' => 'Invalid halaqa ID'], 400);
        }

        $stmt = $conn->prepare("DELETE FROM halaqa_schedule WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            response(['status' => 'success', 'message' => 'Halaqa deleted successfully']);
        } else {
            response(['status' => 'error', 'message' => 'Failed to delete halaqa'], 500);
        }
        break;

    // ================= INVALID ACTION =================
    default:
        response(['status' => 'error', 'message' => 'Invalid action'], 400);
}
