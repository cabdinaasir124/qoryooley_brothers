<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <!-- Teacher Management Card -->
      <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Teacher Management</h5>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
            <i class="fas fa-plus"></i> Add New Teacher
          </button>
        </div>
        <div class="card-body">
          <table id="teacherTable" class="table table-bordered table-striped">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Teacher ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Qualification</th>
            
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="teacherTableBody">
              <!-- Populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>

       <!-- Add Teacher Modal -->
      <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" id="editTeacherModalContent">
           
          </div>
        </div>
      </div>





   <!-- Add Teacher Modal -->
      <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="addTeacherForm">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Register New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body row g-3">
                <div class="col-md-6">
                  <label class="form-label">Teacher ID</label>
                  <input type="text" name="teacher_code" class="form-control" id="teacherCode" readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Assign Class</label>
                  <select name="class_id" class="form-select" id="classDropdown" required>
                    <option value="">-- Select Class --</option>
                    <!-- Populated by JS -->
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Qualification</label>
                  <input type="text" name="qualification" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Salary (USD)</label>
                  <input type="number" name="salary" class="form-control" step="0.01" min="0" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Teacher</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>




      <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Teacher Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- JS will fill this area -->
      </div>
    </div>
  </div>
</div>




 

     
  


      
    </div>
  </div>
</div>

