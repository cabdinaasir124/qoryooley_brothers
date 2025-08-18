<?php
include '../config/conn.php';

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes ORDER BY class_name ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Result View</title>
<style>
.card { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.modal-header { background-color: #0d6efd; color: white; }
.table thead { background-color: #0d6efd; color: white; }
</style>
</head>
<body>
<div class="content-page">
  <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
<div class="container mt-4">
    <h2 class="mb-4">📄 Exam Result View</h2>

    <!-- Filter Form -->
    <div class="card p-4 mb-4">
        <form id="filterForm" class="row g-3">
            <div class="col-md-4">
                <label for="class_id" class="form-label">Select Class</label>
                <select id="class_id" name="class_id" class="form-select">
                    <option value="">-- Select Class --</option>
                    <?php foreach($classes as $cls): ?>
                        <option value="<?= $cls['id'] ?>"><?= $cls['class_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="student_name" class="form-label">Search Student</label>
                <input type="text" id="student_name" class="form-control" placeholder="Enter student name">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Search Results</button>
            </div>
        </form>
    </div>

    <!-- Results Table -->
    <div class="card p-4">
        <table id="resultsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Exam</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>

<!-- Modal for Student Exam Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Student Exam Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <strong>Student Name:</strong> <span id="modalStudentName"></span><br>
            <strong>Class:</strong> <span id="modalClassName"></span>
        </div>
        <table class="table table-hover table-bordered" id="detailsTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Subject</th>
              <th>Marks Obtained</th>
              <th>Total Marks</th>
              <th>Percentage</th>
              <th>Grade</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>

</script>
</body>
</html>
