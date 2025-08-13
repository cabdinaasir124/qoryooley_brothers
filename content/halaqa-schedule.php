<?php include '../config/conn.php'; ?>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">📅 Halaqa Schedule</h5>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#halaqaModal" onclick="openAddModal()">
                <i class="fas fa-plus-circle"></i> Add Halaqa
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
               <table id="halaqaTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Day</th>
                      <th>Time</th>
                      <th>Subject</th>
                      <th>Teacher</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="halaqaTableBody"></tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Create/Edit Modal -->
      <div class="modal fade" id="halaqaModal" tabindex="-1" aria-labelledby="halaqaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <form id="halaqaForm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="halaqaModalLabel">Add Halaqa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body row">
                <input type="hidden" id="id" name="id">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Day</label>
                  <input type="text" class="form-control" id="day" name="day" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Time</label>
                  <input type="text" class="form-control" id="time" name="time" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Subject</label>
                  <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Teacher</label>
                  <input type="text" class="form-control" id="teacher" name="teacher" required>
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


