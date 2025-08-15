<?php
// teacher-attendance.php
include '../config/conn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? '';

    if (!empty($_POST['attendance']) && $date) {
        foreach ($_POST['attendance'] as $teacher_id => $status) {
            $remarks = $_POST['remarks'][$teacher_id] ?? '';

            // Check if attendance already exists
            $check = $conn->prepare("SELECT id FROM teacher_attendance WHERE teacher_id=? AND date=?");
            $check->bind_param("is", $teacher_id, $date);
            $check->execute();
            $check->store_result();

            if ($check->num_rows == 0) {
                // Insert new record
                $stmt = $conn->prepare("
                    INSERT INTO teacher_attendance (teacher_id, date, status, remarks)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bind_param("isss", $teacher_id, $date, $status, $remarks);
                $stmt->execute();
            } else {
                // Update existing record
                $update = $conn->prepare("
                    UPDATE teacher_attendance SET status=?, remarks=? WHERE teacher_id=? AND date=?
                ");
                $update->bind_param("ssis", $status, $remarks, $teacher_id, $date);
                $update->execute();
            }
        }

        // Redirect to prevent resubmission
        header("Location: teacher-attendance.php?success=1&date=" . urlencode($date));
        exit();
    } else {
        header("Location: teacher-attendance.php?error=1");
        exit();
    }
}

// Success/Error messages after redirect
$success = '';
$error = '';
if (isset($_GET['success'])) {
    $success = "Attendance marked successfully for " . htmlspecialchars($_GET['date']) . "!";
} elseif (isset($_GET['error'])) {
    $error = "Please select a date and mark attendance for all teachers.";
}

// Fetch teachers
$teachers = $conn->query("SELECT id, full_name FROM teachers ORDER BY full_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Attendance</title>


<style>
/* === Light/Dark Mode Variables === */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--bg-color);
    color: var(--text-color);
    transition: all 0.3s;
}

.card {
    background-color: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
}

.card-header {
    background-color: var(--card-header-bg);
    color: var(--card-header-text);
    border-bottom: 1px solid var(--card-border);
}

.table {
    color: var(--text-color);
    border-color: var(--card-border);
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: var(--table-stripe);
}

.table-hover tbody tr:hover {
    background-color: var(--table-hover);
}

.table-bordered th, .table-bordered td {
    border: 1px solid var(--card-border) !important;
}

.form-control, .form-select {
    background-color: var(--input-bg);
    color: var(--text-color);
    border: 1px solid var(--card-border);
    border-radius: 6px;
}

.form-control::placeholder {
    color: var(--placeholder-color);
}

input[type="radio"] {
    accent-color: #0d6efd;
    transform: scale(1.2);
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    border-radius: 6px;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #0b5ed7;
}

.alert-success, .alert-danger {
    border-radius: 10px;
    padding: 10px 20px;
}

/* === Dark Mode Variables === */
body.dark-mode {
    --bg-color: #121212;
    --text-color: #e0e0e0;
    --card-bg: #1e1e1e;
    --card-border: #333;
    --card-header-bg: #1a1a1a;
    --card-header-text: #fff;
    --table-stripe: #1a1a1a;
    --table-hover: #2c2c2c;
    --input-bg: #2c2c2c;
    --placeholder-color: #888;
}

/* === Light Mode Variables === */
body.light-mode {
    --bg-color: #f8f9fa;
    --text-color: #212529;
    --card-bg: #ffffff;
    --card-border: #dee2e6;
    --card-header-bg: #e9ecef;
    --card-header-text: #212529;
    --table-stripe: #f2f2f2;
    --table-hover: #e9ecef;
    --input-bg: #ffffff;
    --placeholder-color: #6c757d;
}
</style>
</head>
<body class="light-mode"> <!-- Default light mode -->
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
<div class="container-fluid my-4">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Teacher Attendance</h5>
            <span class="text-muted small">Date: <?= date('Y-m-d') ?></span>
        </div>

        <div class="card-body">
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label fw-bold">Select Date</label>
                    <div class="col-sm-4">
                        <input type="date" name="date" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-striped table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th class="text-start">Teacher Name</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th>Leave</th>
                                <th class="text-start">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($teacher = $teachers->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td class="text-start"><?= htmlspecialchars($teacher['full_name']) ?></td>

                                <td><input type="radio" name="attendance[<?= $teacher['id'] ?>]" value="Present" required></td>
                                <td><input type="radio" name="attendance[<?= $teacher['id'] ?>]" value="Absent"></td>
                                <td><input type="radio" name="attendance[<?= $teacher['id'] ?>]" value="Late"></td>
                                <td><input type="radio" name="attendance[<?= $teacher['id'] ?>]" value="Leave"></td>

                                <td class="text-start">
                                    <input type="text" name="remarks[<?= $teacher['id'] ?>]" class="form-control" placeholder="Optional">
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Save Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
    </div>
  </div>


<script>
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        responsive: true,
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
    });

    // Optional: toggle light/dark mode
    // Example: press 'd' for dark, 'l' for light
    $(document).on('keypress', function(e){
        if(e.key === 'd') document.body.className='dark-mode';
        if(e.key === 'l') document.body.className='light-mode';
    });
});
</script>
</body>
</html>
