<?php
header('Content-Type: application/json');
include '../config/conn.php';

function response($data) {
    echo json_encode($data);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'fetch') {
    $result = $conn->query("SELECT * FROM tajweed_records ORDER BY date DESC");
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    response($records);
}

if ($action === 'create') {
    $stmt = $conn->prepare("INSERT INTO tajweed_records (student_name, lesson, date, remarks) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['student_name'], $_POST['lesson'], $_POST['date'], $_POST['remarks']);
    $stmt->execute();
    response(['status' => 'success', 'message' => 'Record added successfully']);
}elseif($action === 'edit_tajweed') {
    if (empty($_POST['id'])) response(['status' => 'error', 'message' => 'Invalid ID']);
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT * FROM tajweed_records WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        response(['status' => 'success', 'row' => $row]);
    } else {
        response(['status' => 'error', 'message' => 'Record not found']);
    }
}elseif ($action === 'update') {
    if (empty($_POST['id'])) response(['status' => 'error', 'message' => 'Invalid ID']);
    $stmt = $conn->prepare("UPDATE tajweed_records SET student_name=?, lesson=?, date=?, remarks=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['student_name'], $_POST['lesson'], $_POST['date'], $_POST['remarks'], $_POST['id']);
    $stmt->execute();
    response(['status' => 'success', 'message' => 'Record updated successfully']);
}

if ($action === 'delete') {
    if (empty($_POST['id'])) response(['status' => 'error', 'message' => 'Invalid ID']);
    $stmt = $conn->prepare("DELETE FROM tajweed_records WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    response(['status' => 'success', 'message' => 'Record deleted successfully']);
}

response(['status' => 'error', 'message' => 'Invalid action']);
