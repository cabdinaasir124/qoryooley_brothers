<?php
include '../config/conn.php';
if ($_GET['action'] === 'list_exams') {
    header('Content-Type: text/html'); // ✅ HTML for rendering table rows
} else {
    header('Content-Type: application/json'); // ✅ JSON for API responses
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create_exam') {
    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $term = $_POST['term'] ?? '';
    $status = $_POST['status'] ?? '';
    $academic_year_id = intval($_POST['academic_year_id'] ?? 0);
    $class_ids = $_POST['class_ids'] ?? [];

    if (!$title || !$date || !$term || !$status || $academic_year_id === 0 || !is_array($class_ids) || count($class_ids) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    // Expand all classes if "all" selected
    if (in_array("all", $class_ids)) {
        $class_ids = [];
        $res = $conn->query("SELECT id FROM classes");
        while ($row = $res->fetch_assoc()) {
            $class_ids[] = $row['id'];
        }
    }

    $insertedCount = 0;
    foreach ($class_ids as $class_id) {
        // Avoid duplicates
        $check = $conn->prepare("SELECT id FROM exams WHERE title = ? AND date = ? AND term = ? AND class_id = ? AND academic_year_id = ?");
        $check->bind_param("sssii", $title, $date, $term, $class_id, $academic_year_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO exams (title, date, term, status, academic_year_id, class_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssii", $title, $date, $term, $status, $academic_year_id, $class_id);
            if ($stmt->execute()) {
                $insertedCount++;
            }
        }
    }

    echo json_encode([
        'status' => $insertedCount > 0 ? 'success' : 'error',
        'message' => $insertedCount > 0 ? "$insertedCount exam(s) created successfully." : "No exams were created (maybe duplicates)."
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'list_exams') {
    // Return table rows (<tr>) for DataTable
    $sql = "SELECT e.id, e.title, e.date, e.term, e.status, 
                   c.class_name, y.year_name
            FROM exams e
            JOIN classes c ON e.class_id = c.id
            JOIN academic_years y ON e.academic_year_id = y.id
            ORDER BY e.date DESC";

    $result = $conn->query($sql);
    $output = '';
    $count = 1;

    while ($row = $result->fetch_assoc()) {
        $statusBadge = $row['status'] === 'published'
            ? "<span class='badge bg-success'>Published</span>"
            : "<span class='badge bg-secondary'>Draft</span>";

        $output .= "
        <tr>
            <td>{$count}</td>
            <td>{$row['title']}</td>
            <td>{$row['class_name']}</td>
            <td>{$row['term']}</td>
            <td>{$row['date']}</td>
            <td>{$statusBadge}</td>
            <td>
                <button class='btn btn-sm btn-danger'>Delete</button>
            </td>
        </tr>";
        $count++;
    }

    echo $output ?: "<tr><td colspan='7' class='text-center'>No exams found.</td></tr>";
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
