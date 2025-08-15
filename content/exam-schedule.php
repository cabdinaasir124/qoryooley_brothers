<?php
require '../config/conn.php';

// Get academic year ID from URL
$academic_year_id = $_GET['academic_year_id'] ?? 0;
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name ASC");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name ASC");
?>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">📅 Exam Schedule</h5>
              <div>
                <select id="filter_class" class="form-select d-inline-block" style="width:auto;">
                  <option value="">All Classes</option>
                  <?php while($class = $classes->fetch_assoc()): ?>
                      <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                  <?php endwhile; ?>
                </select>

                <select id="filter_exam_type" class="form-select d-inline-block" style="width:auto;">
                  <option value="">All Exam Types</option>
                  <option value="Term-1">Term 1</option>
                  <option value="Mid-Term">Mid-Term</option>
                  <option value="Term-2">Term 2</option>
                  <option value="Final">Final</option>
                </select>

                <button class="btn btn-primary" onclick="openAddModal()">
                  <i class="fas fa-plus-circle"></i> Add Exam
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="examscheduleTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Subject</th>
                      <th>Class</th>
                      <th>Date</th>
                      <th>Day</th>
                      <th>Exam Type</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="examScheduleTableBody"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="examModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <form id="examForm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="examModalLabel">Add Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body row">
                <input type="hidden" id="id" name="id">
                <input type="hidden" name="academic_year_id" value="<?= htmlspecialchars($academic_year_id) ?>">

                <div class="col-md-6 mb-3">
                  <label class="form-label">Subject</label>
                  <select class="form-select" id="subject_id" name="subject_id" required>
                    <option value="">Select Subject</option>
                    <?php while($subject = $subjects->fetch_assoc()): ?>
                      <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['subject_name']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Class</label>
                  <select class="form-select" id="class_id" name="class_id" required>
                    <option value="">Select Class</option>
                    <?php
                      $classes->data_seek(0);
                      while($class = $classes->fetch_assoc()):
                    ?>
                      <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="col-md-4 mb-3">
                  <label class="form-label">Exam Date</label>
                  <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                </div>

                <div class="col-md-4 mb-3">
                  <label class="form-label">Exam Type</label>
                  <select class="form-select" id="exam_type" name="exam_type" required>
                    <option value="">Select Type</option>
                    <option value="Term-1">Term 1</option>
                    <option value="Mid-Term">Mid-Term</option>
                    <option value="Term-2">Term 2</option>
                    <option value="Final">Final</option>
                  </select>
                </div>

                <div class="col-md-4 mb-3">
                  <label class="form-label">Start Time</label>
                  <input type="time" class="form-control" id="exam_start_time" name="exam_start_time" required>
                </div>

                <div class="col-md-4 mb-3">
                  <label class="form-label">End Time</label>
                  <input type="time" class="form-control" id="exam_end_time" name="exam_end_time" required>
                </div>

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

