<?php
require '../config/conn.php';

// Get selected date and class
$date = $_GET['date'] ?? date('Y-m-d'); // default today
$class_id = $_GET['class_id'] ?? '';

// Fetch all classes for dropdown
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");

// Prepare query with optional class filter
$sql = "SELECT a.id, s.full_name AS student_name, c.class_name, a.date, a.status
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        JOIN classes c ON s.class_id = c.id
        WHERE a.date = ?";
$params = [$date];
$types = "s";

if ($class_id) {
    $sql .= " AND s.class_id = ?";
    $params[] = $class_id;
    $types .= "i";
}

$sql .= " ORDER BY c.class_name, s.full_name";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$attendance = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Daily Attendance Report</title>
<style>
.card { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
h3 { color: #343a40; }
.dataTables_wrapper .dataTables_filter input { border-radius: 8px; }
.badge { font-size: 0.9em; }
</style>
</head>
<body>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
<div class="container my-4">
    <div class="card p-4">
        <h3>Daily Attendance Report</h3>

        <!-- Filter Form -->
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <label for="date" class="form-label">Select Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= $date ?>">
            </div>
            <div class="col-md-3">
                <label for="class_id" class="form-label">Select Class:</label>
                <select id="class_id" name="class_id" class="form-select">
                    <option value="">All Classes</option>
                    <?php while($c = $classes->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>" <?= $class_id == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['class_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </div>
        </form>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table id="attendanceTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($attendance) > 0): ?>
                        <?php foreach($attendance as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['student_name']) ?></td>
                                <td><?= htmlspecialchars($row['class_name']) ?></td>
                                <td><?= $row['date'] ?></td>
                                <td>
                                    <?php if($row['status'] == 'Present'): ?>
                                        <span class="badge bg-success">Present</span>
                                    <?php elseif($row['status'] == 'Absent'): ?>
                                        <span class="badge bg-danger">Absent</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
    </div>
  </div>
</body>
</html>
