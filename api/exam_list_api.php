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
                <button data-bs-toggle='modal' data-bs-target='#updateExamModal' class='btn btn-sm btn-success examEdit' exam-id='{$row['id']}'>Update</button>
                <button class='btn btn-sm btn-danger examDelete' exam-id='{$row['id']}'>Delete</button>
            </td>
        </tr>";
        $count++;
    }

    echo $output ?: "<tr><td colspan='7' class='text-center'>No exams found.</td></tr>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete_exam') {
    $id = intval($_POST['id'] ?? 0);
    if ($id === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid exam ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM exams WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Exam deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete exam.']);
    }
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'ReadUpdate_exam') {
    $id = intval($_GET['id'] ?? 0);
    
    // Hel xogta exam-ka
    $sql = "SELECT * FROM exams WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    $exam = mysqli_fetch_assoc($res);

    if (!$exam) {
        echo json_encode(['status' => 'error', 'message' => 'Exam not found']);
        exit;
    }

    // Academic Years
    $yearOptions = "";
    $years = $conn->query("SELECT * FROM academic_years");
    while ($yr = $years->fetch_assoc()) {
        $selected = ($yr['id'] == $exam['academic_year_id']) ? "selected" : "";
        $yearOptions .= "<option value='{$yr['id']}' $selected>{$yr['year_name']}</option>";
    }

    // Classes
    $classOptions = "";
    $selectedClassIds = explode(',', $exam['class_id']); // '2,4' => ['2','4']
    $classes = $conn->query("SELECT * FROM classes");
    while ($cls = $classes->fetch_assoc()) {
        $selected = in_array($cls['id'], $selectedClassIds) ? "selected" : "";
        $classOptions .= "<option value='{$cls['id']}' $selected>{$cls['class_name']}</option>";
    }

    // Modal Form
    ob_start(); ?>
    <form id="examFormUpdate">
        <input type="hidden" name="id" value="<?= $exam['id'] ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Title</label>
                    <input type="text" class="form-control" name="title" value="<?= $exam['title'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Date</label>
                    <input type="date" class="form-control" name="date" value="<?= $exam['date'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Term</label>
                    <select class="form-select" name="term" required>
                        <?php
                        $terms = ["Term 1", "Mid-Term", "Term 2", "Final"];
                        foreach ($terms as $term) {
                            $sel = ($term == $exam['term']) ? "selected" : "";
                            echo "<option value='$term' $sel>$term</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="draft" <?= $exam['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= $exam['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Academic Year</label>
                    <select class="form-select" name="academic_year_id" required>
                        <option value="">Select Year</option>
                        <?= $yearOptions ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Assign to Classes</label>
                    <select class="form-select" name="class_ids[]" multiple required>
                        <option value="all" <?= in_array("all", $selectedClassIds) ? 'selected' : '' ?>>All Classes</option>
                        <?= $classOptions ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update Exam</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
    <?php
    $html = ob_get_clean();
    echo json_encode(['status' => 'success', 'html' => $html]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_exam') {
    $id = intval($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $term = $_POST['term'] ?? '';
    $status = $_POST['status'] ?? '';
    $academic_year_id = intval($_POST['academic_year_id'] ?? 0);
    $class_ids = $_POST['class_ids'] ?? [];

    if ($id === 0 || !$title || !$date || !$term || !$status || $academic_year_id === 0 || !is_array($class_ids) || count($class_ids) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Missing or invalid fields.']);
        exit;
    }

    // Expand classes if "all" is selected
    if (in_array("all", $class_ids)) {
        $class_ids = [];
        $res = $conn->query("SELECT id FROM classes");
        while ($row = $res->fetch_assoc()) {
            $class_ids[] = $row['id'];
        }
    }

    // Re-insert updated exams for selected classes
    $class_id = intval($class_ids[0]); // first only
$stmt = $conn->prepare("UPDATE exams 
    SET title = ?, date = ?, term = ?, status = ?, academic_year_id = ?, class_id = ?
    WHERE id = ?");
$stmt->bind_param("ssssiii", $title, $date, $term, $status, $academic_year_id, $class_id, $id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Exam updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update exam.']);
}
exit;

   
}


echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);

?>

