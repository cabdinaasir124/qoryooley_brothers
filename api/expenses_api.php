<?php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

function response($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

// 📌 FETCH ALL EXPENSES
if ($action === 'fetch') {
    $sql = "SELECT expense_id, title, description, amount, `date`, category 
            FROM expenses 
            ORDER BY `date` DESC";
    $result = $conn->query($sql);

    if (!$result) {
        response(['status' => 'error', 'message' => $conn->error], 500);
    }

    $expenses = [];
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    response($expenses);
}

// 📌 CREATE EXPENSE
elseif ($action === 'create') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? date('Y-m-d');
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("INSERT INTO expenses (title, description, amount, `date`, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $title, $description, $amount, $date, $category);

    if ($stmt->execute()) {
        response(['status' => 'success']);
    } else {
        response(['status' => 'error', 'message' => $stmt->error], 500);
    }
}

// 📌 UPDATE EXPENSE
elseif ($action === 'update') {
    $id = intval($_POST['expense_id'] ?? 0);
    if ($id <= 0) {
        response(['status' => 'error', 'message' => 'Invalid expense ID'], 400);
    }

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $date = $_POST['date'] ?? date('Y-m-d');
    $category = $_POST['category'] ?? '';

    $stmt = $conn->prepare("UPDATE expenses 
                            SET title = ?, description = ?, amount = ?, `date` = ?, category = ? 
                            WHERE expense_id = ?");
    $stmt->bind_param("ssdssi", $title, $description, $amount, $date, $category, $id);

    if ($stmt->execute()) {
        response(['status' => 'updated']);
    } else {
        response(['status' => 'error', 'message' => $stmt->error], 500);
    }
}

// 📌 GET SINGLE EXPENSE
elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        response(['status' => 'error', 'message' => 'Invalid expense ID'], 400);
    }

    $stmt = $conn->prepare("SELECT * FROM expenses WHERE expense_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        response($res->fetch_assoc());
    } else {
        response(['status' => 'error', 'message' => 'Record not found'], 404);
    }
}

// 📌 DELETE EXPENSE
elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        response(['status' => 'error', 'message' => 'Invalid expense ID'], 400);
    }

    $stmt = $conn->prepare("DELETE FROM expenses WHERE expense_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        response(['status' => 'deleted']);
    } else {
        response(['status' => 'error', 'message' => $stmt->error], 500);
    }
}

// 📌 GET TOTALS
elseif ($action === 'totals') {
    $incomeQuery = $conn->query("SELECT IFNULL(SUM(amount), 0) AS total_income FROM expenses WHERE category = 'Income'");
    $expenseQuery = $conn->query("SELECT IFNULL(SUM(amount), 0) AS total_expense FROM expenses WHERE category != 'Income'");

    $income = floatval($incomeQuery->fetch_assoc()['total_income']);
    $expenses = floatval($expenseQuery->fetch_assoc()['total_expense']);
    $balance = $income - $expenses;

    response([
        'income' => $income,
        'expenses' => $expenses,
        'balance' => $balance
    ]);
}

// 📌 INVALID ACTION
else {
    response(['status' => 'error', 'message' => 'Invalid action'], 400);
}
?>
