<?php
require '../config/conn.php';

// Get selected month/year or default to current month/year
$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

// Fetch attendance
$sql = "SELECT ta.id, t.full_name AS teacher_name, ta.date, ta.status, ta.remarks
        FROM teacher_attendance ta
        JOIN teachers t ON ta.teacher_id = t.id
        WHERE MONTH(ta.date) = ? AND YEAR(ta.date) = ?
        ORDER BY t.full_name, ta.date";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $month, $year);
$stmt->execute();
$result = $stmt->get_result();
$attendance = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Summary calculations
$total_teachers_sql = "SELECT COUNT(*) AS total FROM teachers";
$total_teachers = $conn->query($total_teachers_sql)->fetch_assoc()['total'];

$present_sql = "SELECT COUNT(*) AS total FROM teacher_attendance WHERE MONTH(date)=? AND YEAR(date)=? AND status='Present'";
$stmt_present = $conn->prepare($present_sql);
$stmt_present->bind_param("ii", $month, $year);
$stmt_present->execute();
$present = $stmt_present->get_result()->fetch_assoc()['total'];

$absent_sql = "SELECT COUNT(*) AS total FROM teacher_attendance WHERE MONTH(date)=? AND YEAR(date)=? AND status='Absent'";
$stmt_absent = $conn->prepare($absent_sql);
$stmt_absent->bind_param("ii", $month, $year);
$stmt_absent->execute();
$absent = $stmt_absent->get_result()->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Attendance Report</title>
<style>
.card { border-radius: 5px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-top:20px; }
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
            <h3>Teacher Attendance Report - <?= date('F', mktime(0,0,0,$month,1)) ?> <?= $year ?></h3>
            <button onclick="window.print()" class="btn btn-primary no-print">Print</button>
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
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </div>
        </form>

        <!-- Summary -->
        <div class="row mb-4 text-center">
            <div class="col-md-4"><div class="card bg-light p-3">Total Teachers<br><strong><?= $total_teachers ?></strong></div></div>
            <div class="col-md-4"><div class="card bg-success text-white p-3">Total Present<br><strong><?= $present ?></strong></div></div>
            <div class="col-md-4"><div class="card bg-danger text-white p-3">Total Absent<br><strong><?= $absent ?></strong></div></div>
        </div>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table id="teacherAttendanceTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Teacher Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['teacher_name']) ?></td>
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
                        <td><?= htmlspecialchars($row['remarks']) ?></td>
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
