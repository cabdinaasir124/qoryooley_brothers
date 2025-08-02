<?php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    $expenses = [];
    $stmt = $conn->query("SELECT id, title, description, amount, date, category, created_at FROM expenses ORDER BY date DESC");

    while ($row = $stmt->fetch_assoc()) {
        $expenses[] = $row;
    }

    echo json_encode($expenses);
    exit;
}

elseif ($action === 'create') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? '';
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("INSERT INTO expenses (title, description, amount, date, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $title, $description, $amount, $date, $category);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit;
}

elseif ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? '';
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("UPDATE expenses SET title=?, description=?, amount=?, date=?, category=? WHERE id=?");
    $stmt->bind_param("ssdssi", $title, $description, $amount, $date, $category, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit;
}

elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo json_encode($res->fetch_assoc());
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
    }
    exit;
}

elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);

    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    exit;
}

// Fallback
http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
