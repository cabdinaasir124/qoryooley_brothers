<?php
require '../config/conn.php';

// Get academic year ID from URL
$academic_year_id = $_GET['academic_year_id'] ?? '';
?>

<!-- Main Content -->
<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <!-- Page Header + Add Button -->
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
              <h5 class="card-title mb-0">Subject List</h5>
              <button class="btn btn-primary" onclick="openAddSubjectModal()">
                <i class="fas fa-plus"></i>&nbsp;Add Subject
                </button>
            </div>

            <!-- Subject Table -->
            <div class="card-body">
<table id="subjectTable" class="table table-bordered table-striped display responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Code</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- DataTables will load data dynamically -->
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal: Add/Edit Subject -->
<!-- Subject Modal -->
<div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="subjectForm" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="subject_id">
          <input type="hidden" name="academic_year_id" value="<?= htmlspecialchars($academic_year_id) ?>">

          <input type="text" name="subject_name" id="subject_name" class="form-control mb-2" placeholder="Subject Name" >
          <input type="text" name="subject_code" id="subject_code" class="form-control mb-2" placeholder="Subject Code" readonly >

          <label>Class</label>
          <select name="class_id" id="class_id" class="form-select mb-2" >
            <option value="">-- Select Class --</option>
            <?php
              $classes = $conn->query("SELECT id, class_name FROM classes WHERE academic_year_id = '$academic_year_id'");
              while ($cls = $classes->fetch_assoc()):
            ?>
              <option value="<?= $cls['id'] ?>"><?= $cls['class_name'] ?></option>
            <?php endwhile; ?>
          </select>

          <textarea name="description" id="description" class="form-control mb-2" placeholder="Description (optional)"></textarea>

          <select name="status" id="status" class="form-select mt-2" >
            <option value="">Select Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
