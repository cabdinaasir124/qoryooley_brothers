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
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal">
                <i class="fas fa-plus"></i>&nbsp;Add New Class
              </button>
            </div><!-- end card header -->

            <div class="card-body">
              <table id="classTable" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Class Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>View</th>
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Example static row -->
                  <!-- <tr>
                    <td>1</td>
                    <td>Grade 4</td>
                    <td>Basic primary school class</td>
                    <td>30</td>
                    <td>180</td>
                    <td><span class="badge bg-success">Ongoing</span></td>
                    <td>2025-07-22</td>
                    <td><button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</button></td>
                    <td><button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</button></td>
                    <td><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></td>
                  </tr> -->
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
<div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="classForm">
        <div class="modal-header">
          <h5 class="modal-title" id="classModalLabel">Add New Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label for="className" class="form-label">Class Name</label>
            <input type="text" class="form-control" id="className" name="class_name" required>
          </div>

          <div class="mb-3">
            <label for="classDescription" class="form-label">Description</label>
            <textarea class="form-control" id="classDescription" name="description" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="maxStudents" class="form-label">Max Students</label>
            <input type="number" class="form-control" id="maxStudents" name="max_students" min="1" required>
          </div>

        <div class="mb-3">
        <label class="form-label">Days Active</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="monday" value="Monday">
            <label class="form-check-label" for="monday">Mon</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="tuesday" value="Tuesday">
            <label class="form-check-label" for="tuesday">Tue</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="wednesday" value="Wednesday">
            <label class="form-check-label" for="wednesday">Wed</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="thursday" value="Thursday">
            <label class="form-check-label" for="thursday">Thu</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="friday" value="Friday">
            <label class="form-check-label" for="friday">Fri</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="saturday" value="Saturday">
            <label class="form-check-label" for="saturday">Sat</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="days_active[]" id="sunday" value="Sunday">
            <label class="form-check-label" for="sunday">Sun</label>
        </div>
        </div>


          <div class="mb-3">
            <label for="classStatus" class="form-label">Status</label>
            <select class="form-select" id="classStatus" name="status" required>
              <option value="">Select Status</option>
              <option value="ongoing">Ongoing</option>
              <option value="completed">Completed</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Class</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
