<?php
include '../config/conn.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// === 1. Summary Stats ===
if ($action === 'summary_stats') {
    // Total Girls
    $girlsResult = mysqli_query($conn, "SELECT COUNT(*) AS total_girls FROM students WHERE gender = 'female'");
    if (!$girlsResult) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (girls): ' . mysqli_error($conn)]);
        exit;
    }
    $girls = mysqli_fetch_assoc($girlsResult)['total_girls'];

    // Total Boys
    $boysResult = mysqli_query($conn, "SELECT COUNT(*) AS total_boys FROM students WHERE gender = 'male'");
    if (!$boysResult) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (boys): ' . mysqli_error($conn)]);
        exit;
    }
    $boys = mysqli_fetch_assoc($boysResult)['total_boys'];

    // Total Teachers
    $teachersResult = mysqli_query($conn, "SELECT COUNT(*) AS total_teachers FROM teachers");
    if (!$teachersResult) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (teachers): ' . mysqli_error($conn)]);
        exit;
    }
    $teachers = mysqli_fetch_assoc($teachersResult)['total_teachers'];

    // Monthly Expenses
   $expensesResult = mysqli_query($conn, "
    SELECT IFNULL(SUM(amount), 0) AS total_expense 
    FROM expenses 
    WHERE category != 'Income' 
      AND MONTH(date) = MONTH(CURDATE()) 
      AND YEAR(date) = YEAR(CURDATE())
");
if (!$expensesResult) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed (expenses): ' . mysqli_error($conn)]);
    exit;
}
$expenseTotal = mysqli_fetch_assoc($expensesResult)['total_expense'];

    // Activities Count
    $activitiesResult = mysqli_query($conn, "SELECT COUNT(*) AS total_activities FROM activities");
    if (!$activitiesResult) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (activities): ' . mysqli_error($conn)]);
        exit;
    }
    $activityCount = mysqli_fetch_assoc($activitiesResult)['total_activities'];

    echo json_encode([
        'girls' => (int)$girls,
        'boys' => (int)$boys,
        'teachers' => (int)$teachers,
        'expenses' => number_format((float)$expenseTotal, 2),
        'activities' => (int)$activityCount
    ]);
    exit;
}


// === 2. Enrollment Stats ===
if ($action === 'enrollment_stats') {
    $query = "
        SELECT c.class_name, COUNT(s.id) AS total_students
        FROM students s
        INNER JOIN classes c ON s.class_id = c.id
        GROUP BY c.class_name
        ORDER BY c.class_name ASC
    ";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (enrollment_stats): ' . mysqli_error($conn)]);
        exit;
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'class' => $row['class_name'],
            'count' => (int)$row['total_students']
        ];
    }

    echo json_encode($data);
    exit;
}

// === 3. Task List ===
if ($action === 'tasks') {
    $query = "SELECT id, title, due_date, is_done FROM tasks ORDER BY due_date ASC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed (tasks): ' . mysqli_error($conn)]);
        exit;
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'due_date' => $row['due_date'],
            'is_done' => $row['is_done']
        ];
    }

    echo json_encode($data);
    exit;
}

// === Default Fallback ===
http_response_code(400);
echo json_encode(['error' => 'Invalid action']);
?>
