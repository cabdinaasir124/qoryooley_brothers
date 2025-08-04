<?php include '../config/conn.php'; ?>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Exam List</h5>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createExamModal">
                <i class="fas fa-plus-circle"></i> Create New Exam
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="examTable" class="table table-bordered table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Exam Title</th>
                      <th>Class</th>
                      <th>Term</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="examData"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="updateExamModal" tabindex="-1" aria-labelledby="updateExamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Form-ka update-ka ayaa ajax ahaan halkan ku dhici doona -->
      </div>
    </div>
  </div>
</div>


      <!-- Modal -->
      <div class="modal fade" id="createExamModal" tabindex="-1" aria-labelledby="createExamLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <form id="examForm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Create New Exam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Exam Title</label>
                  <input type="text" class="form-control" name="title" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Exam Date</label>
                  <input type="date" class="form-control" name="date" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Term</label>
                  <select class="form-select" name="term" required>
                    <option value="Term 1">Term 1</option>
                    <option value="Mid-Term">Mid-Term</option>
                    <option value="Term 2">Term 2</option>
                    <option value="Final">Final</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-select" name="status" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Academic Year</label>
                  <select class="form-select" name="academic_year_id" required>
                    <option value="">Select Year</option>
                    <?php
                    $years = $conn->query("SELECT * FROM academic_years");
                    while ($yr = $years->fetch_assoc()) {
                      echo "<option value='{$yr['id']}'>{$yr['year_name']}</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Assign to Classes</label>
                <select class="form-select" name="class_ids[]" multiple required>
                  <option value="all">All Classes</option>
                  <?php
                  $classes = $conn->query("SELECT * FROM classes");
                  while ($cls = $classes->fetch_assoc()) {
                    echo "<option value='{$cls['id']}'>{$cls['class_name']}</option>";
                  }
                  ?>
                </select>

                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Exam</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
