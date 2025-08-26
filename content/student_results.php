<?php
require '../config/conn.php';

$student_id   = intval($_GET['student_id'] ?? 0);

// Fetch student details (id vs student_id confusion fix)
$student_sql = "SELECT id, student_id, full_name, class_id 
                FROM students 
                WHERE id = $student_id LIMIT 1";
$student_res = $conn->query($student_sql);
$student_data = $student_res->fetch_assoc();

$student_code  = $student_data['student_id']; // ✅ QBS-2526-004
$student_name  = $student_data['full_name'];
$class_id      = $student_data['class_id'];

$student_name = $_GET['student_name'] ?? '';
$class_name   = $_GET['class_name'] ?? '';

// Fetch exam details
$sql = "
    SELECT 
        e.term AS exam_name,          -- Mid-Term / Final
        sub.subject_name, 
        es.max_marks, 
        er.marks_obtained
    FROM exam_results er
    INNER JOIN exam_subjects es ON er.exam_subject_id = es.id
    INNER JOIN subjects sub ON es.subject_id = sub.id
    INNER JOIN exams e ON es.exam_id = e.id
    WHERE er.student_id = $student_id
    ORDER BY e.term, sub.subject_name
";

$res = $conn->query($sql);

$results = [];          // grouped results per exam
$total_obtained = [];   // per exam
$total_marks = [];      // per exam
$grand_total_obtained = 0;
$grand_total_marks = 0;

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $exam = $row['exam_name'];

        $percentage = round(($row['marks_obtained'] / $row['max_marks']) * 100, 2);
        $grade = $percentage >= 90 ? 'A+' :
                 ($percentage >= 80 ? 'A' :
                 ($percentage >= 70 ? 'B+' :
                 ($percentage >= 60 ? 'B' :
                 ($percentage >= 50 ? 'C' : 'F'))));

        $results[$exam][] = [
            'subject_name'   => $row['subject_name'],
            'marks_obtained' => $row['marks_obtained'],
            'max_marks'      => $row['max_marks'],
            'percentage'     => $percentage,
            'grade'          => $grade
        ];

        $total_obtained[$exam] = ($total_obtained[$exam] ?? 0) + $row['marks_obtained'];
        $total_marks[$exam]    = ($total_marks[$exam] ?? 0) + $row['max_marks'];

        $grand_total_obtained += $row['marks_obtained'];
        $grand_total_marks    += $row['max_marks'];
    }
}

$overall_percentage = $grand_total_marks > 0 ? round(($grand_total_obtained / $grand_total_marks) * 100, 2) : 0;
$overall_grade = $overall_percentage >= 90 ? 'A+' :
                 ($overall_percentage >= 80 ? 'A' :
                 ($overall_percentage >= 70 ? 'B+' :
                 ($overall_percentage >= 60 ? 'B' :
                 ($overall_percentage >= 50 ? 'C' : 'F'))));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Report Card - <?= htmlspecialchars($student_name) ?></title>
  <style>
body.report-body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }

.report-wrapper {
  width: 100%;
  max-width: 1000px;
  margin: 30px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0,0,0,.15);
  padding: 30px 40px;
}

.report-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
.report-table th, .report-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}
.report-table th { background: #343a40; color: #fff; }
.report-table tfoot td { font-weight: bold; background: #f1f1f1; }

.report-badge {
  padding: 3px 10px;
  border-radius: 6px;
  color: #fff;
  font-size: 13px;
  font-weight: bold;
}
.badge-pass { background: #28a745; }
.badge-fail { background: #dc3545; }
.badge-neutral { background: #007bff; }

.report-header { text-align: center; margin-bottom: 20px; }
.report-header img { height: 80px; margin-bottom: 10px; }
.report-header h2 { margin: 5px 0; font-size: 24px; font-weight: bold; text-transform: uppercase; }
.report-header small { color: #6c757d; font-size: 14px; }

.report-info { display: flex; justify-content: space-between; margin: 20px 0; font-size: 15px; }

.report-footer { margin-top: 50px; display: flex; justify-content: space-around; text-align: center; }
.report-footer div { width: 40%; }
.report-footer hr { margin-bottom: 5px; }

.report-actions { margin-top: 30px; text-align: center; }
.report-actions button, .report-actions a {
  padding: 10px 15px;
  margin: 5px;
  border: none;
  border-radius: 6px;
  text-decoration: none;
  cursor: pointer;
  font-size: 14px;
}
.btn-print { background: #007bff; color: #fff; }
.btn-whatsapp { background: #25d366; color: #fff; }

/* ===== Print Styles ===== */
/* ===== Print Styles ===== */
@media print {
  body.report-body {
    background: #fff;
    margin: 0;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }

  .report-wrapper {
    width: 210mm;     /* A4 width */
    min-height: 297mm; /* A4 height */
    box-shadow: none;
    margin: 0 auto;
    padding: 10mm;     /* uniform padding */
    page-break-after: always;
  }

  .report-table th, .report-table td {
    padding: 6px;
    font-size: 12px;
  }

  .report-actions { display: none; }

  @page {
    size: A4 portrait;
    margin: 10mm;  /* adjust margin for print */
  }
}

  </style>
</head>
<body class="report-body">
<div class="content-page">
  <div class="content">
    <div class="container-fluid">

<div class="report-wrapper">
  <div class="report-header">
    <img src="../assets/images/logo.jpg" alt="School Logo">
    <h2>United Qoryooley Brothers & Sisters</h2>
    <small>Student Academic Report Card</small>
    <hr>
  </div>

  <div class="report-info">
    <div><strong>Student:</strong> <?= htmlspecialchars($student_name) ?></div>
    <div><strong>Student ID:</strong> <?= htmlspecialchars($student_code) ?></div>
    <div><strong>Class:</strong> <?= htmlspecialchars($class_name) ?></div>
  </div>

  <?php if (!empty($results)): ?>
    <?php foreach ($results as $exam => $rows): ?>
      <h3 style="margin-top:30px;"><?= htmlspecialchars($exam) ?> Results</h3>
      <table class="report-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Subject</th>
            <th>Marks Obtained</th>
            <th>Total Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $row): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= htmlspecialchars($row['subject_name']) ?></td>
              <td><?= $row['marks_obtained'] ?></td>
              <td><?= $row['max_marks'] ?></td>
              <td><?= $row['percentage'] ?>%</td>
              <td>
                <span class="report-badge <?= $row['grade']=='F' ? 'badge-fail' : 'badge-pass' ?>">
                  <?= $row['grade'] ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <?php
            $exam_percentage = round(($total_obtained[$exam] / $total_marks[$exam]) * 100, 2);
            $exam_grade = $exam_percentage >= 90 ? 'A+' :
                          ($exam_percentage >= 80 ? 'A' :
                          ($exam_percentage >= 70 ? 'B+' :
                          ($exam_percentage >= 60 ? 'B' :
                          ($exam_percentage >= 50 ? 'C' : 'F'))));
          ?>
          <tr>
            <td colspan="2">Total</td>
            <td><?= $total_obtained[$exam] ?></td>
            <td><?= $total_marks[$exam] ?></td>
            <td><?= $exam_percentage ?>%</td>
            <td>
              <span class="report-badge <?= $exam_grade=='F' ? 'badge-fail' : 'badge-neutral' ?>">
                <?= $exam_grade ?>
              </span>
            </td>
          </tr>
        </tfoot>
      </table>
    <?php endforeach; ?>

    <h3 style="margin-top:40px;">Overall Performance</h3>
    <table class="report-table">
      <thead>
        <tr>
          <th>Total Obtained</th>
          <th>Total Marks</th>
          <th>Percentage</th>
          <th>Grade</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $grand_total_obtained ?></td>
          <td><?= $grand_total_marks ?></td>
          <td><?= $overall_percentage ?>%</td>
          <td>
            <span class="report-badge <?= $overall_grade=='F' ? 'badge-fail' : 'badge-neutral' ?>">
              <?= $overall_grade ?>
            </span>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="report-footer">
      <div>
        <hr>
        <small>Class Teacher</small>
      </div>
      <div>
        <hr>
        <small>Principal</small>
      </div>
    </div>
  <?php else: ?>
    <p style="text-align:center; color:#d9534f;">⚠️ No results found for this student.</p>
  <?php endif; ?>

  <div class="report-actions">
    <button onclick="window.print()" class="btn-print">🖨️ Print</button>
    <a href="https://wa.me/?text=<?= urlencode('Check '.$student_name.' ('.$class_name.') Report Card: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" target="_blank" class="btn-whatsapp">📲 Share via WhatsApp</a>
  </div>
</div>

    </div>
  </div>
</div>
</body>
</html>
