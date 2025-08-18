<?php include '../config/conn.php'; ?>
<?php /* include your header if you have one */ ?>

<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <!-- Page Title -->
      <div class="row mt-3">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">📊 Exam Results</h5>
            </div>
            <div class="card-body">

              <!-- Filters -->
              <form id="filterForm" class="row g-3 mb-4">
                <div class="col-md-3">
                  <label class="form-label">Academic Year</label>
                  <select id="academic_year_id" class="form-select">
                    <option value="">Select Academic Year</option>
                    <?php
                      // Safer ordering (id should exist); show helpful error if query fails
                      $years = mysqli_query($conn, "SELECT * FROM academic_years ORDER BY id DESC");
                      if ($years === false) {
                        echo "<option disabled>Error: ".htmlspecialchars(mysqli_error($conn))."</option>";
                      } else {
                        while ($row = mysqli_fetch_assoc($years)) {
                          // Try common column names for label
                          $label = '';
                          if (isset($row['year_name'])) $label = $row['year_name'];
                          elseif (isset($row['name'])) $label = $row['name'];
                          elseif (isset($row['title'])) $label = $row['title'];
                          elseif (isset($row['start_year']) && isset($row['end_year'])) $label = $row['start_year'].'/'.$row['end_year'];
                          else $label = 'Year #'.$row['id'];

                          $idVal = isset($row['id']) ? $row['id'] : (isset($row['academic_year_id']) ? $row['academic_year_id'] : '');
                          echo "<option value='".htmlspecialchars($idVal, ENT_QUOTES)."'>".htmlspecialchars($label)."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Class</label>
                  <select id="class_id" class="form-select">
                    <option value="">Select Class</option>
                    <?php
                      $classes = mysqli_query($conn, "SELECT * FROM classes ORDER BY id ASC");
                      if ($classes === false) {
                        echo "<option disabled>Error: ".htmlspecialchars(mysqli_error($conn))."</option>";
                      } else {
                        while ($row = mysqli_fetch_assoc($classes)) {
                          $label = isset($row['class_name']) ? $row['class_name'] : (isset($row['name']) ? $row['name'] : 'Class #'.$row['id']);
                          $idVal = isset($row['id']) ? $row['id'] : (isset($row['class_id']) ? $row['class_id'] : '');
                          echo "<option value='".htmlspecialchars($idVal, ENT_QUOTES)."'>".htmlspecialchars($label)."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Exam</label>
                  <select id="exam_id" class="form-select">
                    <option value="">Select Exam</option>
                    <?php
                      $exams = mysqli_query($conn, "SELECT * FROM exams ORDER BY id ASC");
                      if ($exams === false) {
                        echo "<option disabled>Error: ".htmlspecialchars(mysqli_error($conn))."</option>";
                      } else {
                        while ($row = mysqli_fetch_assoc($exams)) {
                          $label = isset($row['exam_name']) ? $row['exam_name'] : (isset($row['name']) ? $row['name'] : $row['title']);
                          $idVal = isset($row['id']) ? $row['id'] : (isset($row['exam_id']) ? $row['exam_id'] : '');
                          echo "<option value='".htmlspecialchars($idVal, ENT_QUOTES)."'>".htmlspecialchars($label)."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Subject</label>
                  <select id="subject_id" class="form-select">
                    <option value="">Select Subject</option>
                    <?php
                      $subjects = mysqli_query($conn, "SELECT * FROM subjects ORDER BY id ASC");
                      if ($subjects === false) {
                        echo "<option disabled>Error: ".htmlspecialchars(mysqli_error($conn))."</option>";
                      } else {
                        while ($row = mysqli_fetch_assoc($subjects)) {
                          $label = isset($row['subject_name']) ? $row['subject_name'] : (isset($row['name']) ? $row['name'] : 'Subject #'.$row['id']);
                          $idVal = isset($row['id']) ? $row['id'] : (isset($row['subject_id']) ? $row['subject_id'] : '');
                          echo "<option value='".htmlspecialchars($idVal, ENT_QUOTES)."'>".htmlspecialchars($label)."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>

                <div class="col-md-12 text-end">
                  <button type="button" id="loadStudents" class="btn btn-primary">
                    <i class="bi bi-search"></i> Load Students
                  </button>
                </div>
              </form>

              <!-- Students Table -->
              <div class="table-responsive">
                <table id="resultsTable" class="table table-bordered table-striped table-hover">
                  <thead class="table-primary">
                    <tr>
                      <th>#</th>
                      <th>Student ID</th>
                      <th>Student Name</th>
                      <th>Marks Obtained</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

              <!-- Save Button -->
              <div class="text-end mt-3">
                <button id="saveResults" class="btn btn-success">
                  <i class="bi bi-check2-circle"></i> Save Results
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php /* include your footer if you have one */ ?>

<!-- Dependencies: jQuery, DataTables, SweetAlert should already be in your layout -->
