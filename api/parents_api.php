<?php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    $academic_year_id = intval($_GET['academic_year_id'] ?? 0);

    if ($academic_year_id === 0) {
        echo json_encode([]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, name, phone, relationship_to_student, Address, guarantor FROM parents WHERE academic_year_id = ?");
    $stmt->bind_param("i", $academic_year_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $parents = [];
    while ($row = $result->fetch_assoc()) {
        $parents[] = $row;
    }

    echo json_encode($parents);
    exit;
}

elseif ($action === 'create' || $action === 'update') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['Address'] ?? '';
    $guarantor = $_POST['guarantor'] ?? '';
    $relation = $_POST['relationship_to_student'] ?? '';
    $academic_year_id = intval($_POST['academic_year_id'] ?? 0);

    if ($action === 'create') {
        $stmt = $conn->prepare("INSERT INTO parents (name, phone, Address, guarantor, relationship_to_student, academic_year_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $phone, $address, $guarantor, $relation, $academic_year_id);
        $response = $stmt && $stmt->execute()
            ? ['status' => 'success']
            : ['status' => 'error', 'message' => $conn->error];
    } else {
        $stmt = $conn->prepare("UPDATE parents SET name=?, phone=?, Address=?, guarantor=?, relationship_to_student=?, academic_year_id=? WHERE id=?");
        $stmt->bind_param("sssssii", $name, $phone, $address, $guarantor, $relation, $academic_year_id, $id);
        $response = $stmt && $stmt->execute()
            ? ['status' => 'updated']
            : ['status' => 'error', 'message' => $conn->error];
    }

    echo json_encode($response);
    exit;
}

elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);

    if ($id === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM parents WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        exit;
    }

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'deleted', 'message' => "Parent and linked students deleted"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parent not found or already deleted']);
    }

    $stmt->close();
    exit;
}


elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->query("SELECT * FROM parents WHERE id = $id");
    $parent = $stmt->fetch_assoc();

    $children = [];
    $res = $conn->query("SELECT full_name FROM students WHERE parent_id = $id");
    while ($row = $res->fetch_assoc()) {
        $children[] = $row['full_name'];
    }

    $parent['children'] = $children;

    echo json_encode($parent);
    exit;
}

// Fallback
http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
