<?php
require '../config/conn.php';

// Get selected month/year or default to current month/year
$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');
$class_id = $_GET['class_id'] ?? 0;

// Fetch classes for dropdown
$classes_result = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$classes = $classes_result ? $classes_result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch attendance for selected month and class
$sql = "
    SELECT a.student_id, s.full_name AS student_name, c.class_name, a.date, a.status
    FROM attendance a
    JOIN students s ON a.student_id = s.id
    JOIN classes c ON s.class_id = c.id
    WHERE MONTH(a.date) = ? AND YEAR(a.date) = ?
";
$params = [$month, $year];
$types = "ii";

if ($class_id) {
    $sql .= " AND s.class_id = ?";
    $params[] = $class_id;
    $types .= "i";
}

$sql .= " ORDER BY s.full_name, a.date";

$query = $conn->prepare($sql);
$query->bind_param($types, ...$params);
$query->execute();
$result = $query->get_result();
$attendance = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Summary calculations
$total_students_sql = "SELECT COUNT(*) AS total FROM students";
if ($class_id) $total_students_sql .= " WHERE class_id = $class_id";
$total_students = $conn->query($total_students_sql)->fetch_assoc()['total'];

$present_count_sql = "SELECT COUNT(*) AS total FROM attendance WHERE MONTH(date)=? AND YEAR(date)=? AND status='Present'";
if ($class_id) $present_count_sql .= " AND student_id IN (SELECT id FROM students WHERE class_id=$class_id)";
$present_count = $conn->prepare($present_count_sql);
$present_count->bind_param("ii", $month, $year);
$present_count->execute();
$present = $present_count->get_result()->fetch_assoc()['total'];

$absent_count_sql = "SELECT COUNT(*) AS total FROM attendance WHERE MONTH(date)=? AND YEAR(date)=? AND status='Absent'";
if ($class_id) $absent_count_sql .= " AND student_id IN (SELECT id FROM students WHERE class_id=$class_id)";
$absent_count = $conn->prepare($absent_count_sql);
$absent_count->bind_param("ii", $month, $year);
$absent_count->execute();
$absent = $absent_count->get_result()->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monthly Attendance Report</title>

<style>
.card { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-top:20px; }
h3 { color: #343a40; }
.badge { font-size: 0.9rem; }
@media print {
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { position: absolute; top:0; left:0; width:100%; }
    .no-print { display: none; }
}
</style>
</head>
<body>
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-4">
                <div class="card p-4" id="printableArea">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Monthly Attendance Report - <?= date('F', mktime(0,0,0,$month,1)) ?> <?= $year ?></h3>
                        <button onclick="window.print()" class="btn btn-primary no-print"><i class="fas fa-print"></i> Print</button>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" class="row g-3 mb-3 no-print">
                        <div class="col-md-3">
                            <label for="month" class="form-label">Select Month</label>
                            <select name="month" id="month" class="form-select">
                                <?php for($m=1;$m<=12;$m++): ?>
                                    <option value="<?= $m ?>" <?= $m==$month?'selected':'' ?>><?= date('F', mktime(0,0,0,$m,1)) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="year" class="form-label">Select Year</label>
                            <input type="number" name="year" id="year" class="form-control" value="<?= $year ?>" min="2000" max="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="class_id" class="form-label">Select Class</label>
                            <select name="class_id" id="class_id" class="form-select">
                                <option value="0">All Classes</option>
                                <?php foreach($classes as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= $class_id==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['class_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary mt-2">Filter</button>
                        </div>
                    </form>

                    <!-- Summary -->
                    <div class="row mb-4 text-center">
                        <div class="col-md-4"><div class="card bg-light p-3">Total Students<br><strong><?= $total_students ?></strong></div></div>
                        <div class="col-md-4"><div class="card bg-success text-white p-3">Total Present<br><strong><?= $present ?></strong></div></div>
                        <div class="col-md-4"><div class="card bg-danger text-white p-3">Total Absent<br><strong><?= $absent ?></strong></div></div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="table-responsive">
                        <table id="monthlyAttendanceTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($attendance as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                                    <td><?= htmlspecialchars($row['class_name']) ?></td>
                                    <td><?= $row['date'] ?></td>
                                    <td>
                                        <?php if($row['status']=='Present'): ?>
                                            <span class="badge bg-success">Present</span>
                                        <?php elseif($row['status']=='Absent'): ?>
                                            <span class="badge bg-danger">Absent</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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
