<?php
require '../config/conn.php';
// Get academic year ID from URL
$academic_year_id = $_GET['academic_year_id'] ?? '';
?>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <!-- Parent List Row -->
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
              <h5 class="card-title mb-0">Parent List</h5>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#parentModal">
                <i class="fas fa-plus"></i>&nbsp;Register New Parent
              </button>
            </div>

            <div class="card-body">
              <table id="parentTable" class="table table-striped display responsive  nowrap w-100">
                <?php if (!$academic_year_id): ?>
  <div class="alert alert-warning mt-3">Please select an Academic Year to view parents.</div>
<?php endif; ?>

                <thead>
                  <tr>
                    <th>#</th>
                    <th>Parent Name</th>
                    <th>Phone</th>
                    <th>Relationship</th>
                    
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  
                 <!-- this will dynamically fetch -->
                </tbody>
              </table>
              
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Parent Registration Modal -->
<!-- Parent Modal -->
<div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="parentForm">

      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="parentModalLabel">Register Parent</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <input type="hidden" name="id" id="parent_id">
             <input type="hidden" name="academic_year_id" value="<?= htmlspecialchars($academic_year_id) ?>">

            <div class="col-md-6">
              <label for="parent_name" class="form-label">Full Name</label>
              <input type="text" class="form-control" name="name" id="parent_name" required>
            </div>

            <div class="col-md-6">
              <label for="parent_phone" class="form-label">Phone</label>
              <input type="text" class="form-control" name="phone" id="parent_phone" required>
            </div>

            <!-- Children List (read-only) -->
            <div class="col-md-6">
              <label class="form-label">Registered Children</label>
              <ul class="list-group" id="childrenList">
                <li class="list-group-item text-muted">No children linked</li>
              </ul>
            </div>

            <div class="col-md-6">
              <label for="relationship" class="form-label">Relationship to Student</label>
              <select class="form-select" name="relationship_to_student" id="relationship" required>
                <option value="">Select</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Guardian">Guardian</option>
              </select>
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

