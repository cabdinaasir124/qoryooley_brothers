<?php require '../config/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Subjects</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="content-page">
    <div class="content">
      <div class="container-fluid mt-4">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📘 Exam Subjects</h5>
            <button class="btn btn-primary" onclick="openAddSubjectModal()">+ Add Subject</button>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped table-hover w-100" id="examSubjectsTable">
              <thead class="table-primary">
                <tr>
                  <th>ID</th>
                  <th>Exam</th>
                  <th>Subject</th>
                  <th>Teacher</th>
                  <th>Class</th>
                  <th>Academic Year</th>
                  <th>Exam Date</th>
                  <th>Max Marks</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit Modal -->
  <div class="modal fade" id="subjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form id="examSubjectForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Exam Subject</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <!-- row id (hidden) -->
            <input type="hidden" name="id" id="row_id">

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label">Exam</label>
                <select name="exam_id" id="exam_id" class="form-select" required>
                  <option value="">-- Select Exam --</option>
                  <?php
                  /**
                   * Waxaan halkan ka soo qaadanay exams, annagoo LEFT JOIN ugu daray exam_schedule
                   * si aan u helno exam_type (haddii uu jiro). Value = exams.id (exam_id la kaydinayo).
                   */
                  $exams = $conn->query("
    SELECT e.id AS exam_id, e.title, GROUP_CONCAT(sch.exam_type SEPARATOR ', ') AS exam_type
    FROM exams e
    LEFT JOIN exam_schedule sch ON sch.exam_id = e.id
    GROUP BY e.id, e.title
    ORDER BY e.id DESC
");

if ($exams) {
    while($e = $exams->fetch_assoc()){
        $label = htmlspecialchars(($e['exam_type'] ?? 'No Type').' - '.$e['title']);
        echo "<option value='{$e['exam_id']}'>{$label}</option>";
    }
}


                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                  <option value="">-- Select Subject --</option>
                  <?php
                  $subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY id DESC");
                  if ($subjects) {
                    while($s = $subjects->fetch_assoc()){
                      $label = htmlspecialchars($s['subject_name']);
                      echo "<option value='{$s['id']}'>{$label}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                  <option value="">-- Select Teacher --</option>
                  <?php
                  $teachers = $conn->query("SELECT id, full_name FROM teachers ORDER BY id DESC");
                  if ($teachers) {
                    while($t = $teachers->fetch_assoc()){
                      $label = htmlspecialchars($t['full_name']);
                      echo "<option value='{$t['id']}'>{$label}</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                  <option value="">-- Select Class --</option>
                  <?php
                  $classes = $conn->query("SELECT id, class_name FROM classes ORDER BY id DESC");
                  if ($classes) {
                    while($c = $classes->fetch_assoc()){
                      $label = htmlspecialchars($c['class_name']);
                      echo "<option value='{$c['id']}'>{$label}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label">Academic Year</label>
                <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                  <option value="">-- Select Year --</option>
                  <?php
                  $years = $conn->query("SELECT id, year_name FROM academic_years ORDER BY id DESC");
                  if ($years) {
                    while($y = $years->fetch_assoc()){
                      $label = htmlspecialchars($y['year_name']);
                      echo "<option value='{$y['id']}'>{$label}</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Exam Date</label>
                <input type="date" name="exam_date" id="exam_date" class="form-control" required>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label">Max Marks</label>
                <input type="number" name="max_marks" id="max_marks" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/exam_subjects.js"></script> -->
</body>
</html>
