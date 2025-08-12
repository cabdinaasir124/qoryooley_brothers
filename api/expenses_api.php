<?php
// 📁 File: api/expenses_api.php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

function response($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

if ($action === 'fetch') {
    $expenses = [];
    $sql = "SELECT id, title, description, amount, date, category FROM expenses ORDER BY date DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    response($expenses);
}

elseif ($action === 'create') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? date('Y-m-d');
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("INSERT INTO expenses (title, description, amount, date, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $title, $description, $amount, $date, $category);

    if ($stmt->execute()) {
        response(['status' => 'success']);
    } else {
        response(['status' => 'error', 'message' => $conn->error], 500);
    }
}

elseif ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? date('Y-m-d');
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("UPDATE expenses SET title = ?, description = ?, amount = ?, date = ?, category = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $title, $description, $amount, $date, $category, $id);

    if ($stmt->execute()) {
        response(['status' => 'updated']);
    } else {
        response(['status' => 'error', 'message' => $conn->error], 500);
    }
}

elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        response($res->fetch_assoc());
    } else {
        response(['status' => 'error', 'message' => 'Record not found'], 404);
    }
}

elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        response(['status' => 'deleted']);
    } else {
        response(['status' => 'error', 'message' => $conn->error], 500);
    }
}elseif ($action === 'totals') {
    $incomeQuery = mysqli_query($conn, "SELECT IFNULL(SUM(amount), 0) AS total_income FROM expenses WHERE category = 'Income'");
    $expenseQuery = mysqli_query($conn, "SELECT IFNULL(SUM(amount), 0) AS total_expense FROM expenses WHERE category != 'Income'");

    $income = floatval(mysqli_fetch_assoc($incomeQuery)['total_income']);
    $expenses = floatval(mysqli_fetch_assoc($expenseQuery)['total_expense']);

    // ✅ Update total income to only show what's left
    $available_income = $income - $expenses;
    $balance = $available_income;

    echo json_encode([
        'income' => $available_income,
        'expenses' => $expenses,
        'balance' => $balance
    ]);
    exit;
}





else {
    response(['status' => 'error', 'message' => 'Invalid action'], 400);
}
