<?php
include '../config/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Class Attendance Sheet</title>
  <style>
    .card {
      border-radius: 6px;
      border: 1px solid var(--bs-border-color, #ddd);
      margin-bottom: 30px;
    }

    .card-header {
      padding: 15px;
      border-bottom: 1px solid var(--bs-border-color, #ccc);
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: var(--bs-primary, #007bff);
      color: var(--bs-white, #fff);
    }

    .card-body {
      padding: 20px;
    }

    .form-label {
      font-weight: 600;
    }

    .form-control, .form-select {
      padding: 8px;
      width: 100%;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 8px;
      text-align: center;
      border: 1px solid var(--bs-border-color, #ccc);
    }

    .btn {
      padding: 10px 20px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-success {
      background-color: var(--bs-success, #28a745);
      color: var(--bs-white, #fff);
    }

    .btn-light {
      background-color: var(--bs-light, #f8f9fa);
      color: var(--bs-dark, #000);
    }

    .no-print {
      display: inline-block;
    }

    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <div class="card mt-2">
        <div class="card-header">
          <h5 class="mb-0">📅 Full Class Attendance Sheet</h5>
          <button onclick="window.print()" class="btn btn-light btn-sm no-print">🖨️ Print</button>
        </div>
        <div class="card-body">
          <form id="attendanceSheetForm" action="../api/save_attendance.php" method="post">
            <div class="row mb-3" style="display: flex; gap: 20px; flex-wrap: wrap;">
              <div style="flex: 1; min-width: 250px;">
                <label class="form-label">Select Class</label>
                <select name="class_id" id="classSelector" class="form-select" required>
                  <option value="">-- Select Class --</option>
                  <?php
                  $classes = mysqli_query($conn, "SELECT id, class_name FROM classes");
                  while ($cls = mysqli_fetch_assoc($classes)) {
                    echo "<option value='{$cls['id']}'>{$cls['class_name']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div style="flex: 1; min-width: 250px;">
                <label class="form-label">Date</label>
                <input type="date" name="attendance_date" class="form-control" required>
              </div>
            </div>

            <div id="studentsContainer"></div>

            <button type="submit" class="btn btn-success mt-3 w-100 no-print">💾 Save Attendance</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- AJAX Script -->
<script>
  document.getElementById("classSelector").addEventListener("change", function () {
    const classId = this.value;
    if (!classId) return;

    fetch("../api/php/fetch_students_by_class.php?class_id=" + classId)
      .then(res => res.text())
      .then(html => {
        document.getElementById("studentsContainer").innerHTML = html;
      });
  });
</script>

</body>
</html>
