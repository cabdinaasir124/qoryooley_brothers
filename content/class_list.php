<style>
  #classTable {
    display: table !important;
  }
</style>

<div class="content-page">
  <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
      <!-- Row Created Callback DataTable -->
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
              <h5 class="card-title mb-0">Class List</h5>
              <button class="btn btn-primary" id="addNewBtn" data-bs-toggle="modal" data-bs-target="#classModal">
                <i class="fas fa-plus"></i>&nbsp;Add New Class
              </button>
            </div><!-- end card header -->

            <div class="card-body">
            <table id="row-callback-datatable" class="table table-bordered table-striped w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Class Name</th>
                <th>Description</th>
                <th>Max Students</th>
                <th>Days Active</th>
                <th>Status</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody> <!-- REMOVE id="classTableBody" -->
              <!-- Don't touch this — DataTables will manage it -->
            </tbody>
          </table>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal: Add / Edit Class -->

<!-- Modal -->
<div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="classForm" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="class_id">
<input type="hidden" name="academic_year_id" value="<?php echo htmlspecialchars($_GET['academic_year_id'] ?? ''); ?>">

          <input type="text" name="class_name" class="form-control mb-2" placeholder="Class Name" >
          <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
          <input type="number" name="max_students" class="form-control mb-2" placeholder="Max Students" min="1" >
          
          <label class="form-label">Days Active</label><br>
          <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="days_active[]" value="Monday"> Mon</div>
          <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="days_active[]" value="Tuesday"> Tue</div>
          <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="days_active[]" value="Wednesday"> Wed</div>
          <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="days_active[]" value="Thursday"> Thu</div>
          <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="days_active[]" value="Friday"> Fri</div>
<div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="saturday" value="Saturday">
            <label class="form-check-label" for="saturday">Sat</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="sunday" value="Sunday">
            <label class="form-check-label" for="sunday">Sun</label>
        </div>
          <select name="status" class="form-select mt-2" >
            <option value="">Select Status</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
