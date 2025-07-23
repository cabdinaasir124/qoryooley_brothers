  <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
 <!-- Row Created Callback DataTable -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mt-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title mb-0">student list</h5>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentParentModal">
                                            <i class="fas fa-plus"></i>&nbsp;Add new student
                                        </button>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                       <table id="studentTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Class</th>
                                            <th>Parent Name</th>
                                            <th>view more</th>
                                            <th>update</th>
                                            <th>delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example static row (replace with PHP or JS dynamic later) -->
                                            <tr>
                                            <td>1</td>
                                            <td>Ahmed Ali</td>
                                            <td>Grade 4</td>
                                            <td>Abdi Ali</td>
                                            
                                                <td><button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</button></td>
                                                <td><button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</button></td>
                                                <td><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></td>
                                            </tr>
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
  </div>

  <!-- Modal: Register Student + Parent -->
<div class="modal fade" id="studentParentModal" tabindex="-1" aria-labelledby="studentParentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="registerStudentParentForm">
        <div class="modal-header">
          <h5 class="modal-title" id="studentParentModalLabel">Register Student and Parent</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <h6 class="text-primary mb-3">👨‍👩‍👧 Parent Information</h6>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="parentName" class="form-label">Parent Name</label>
              <input type="text" class="form-control" id="parentName" name="parent_name" required>
            </div>
            <div class="col-md-6">
              <label for="parentPhone" class="form-label">Phone</label>
              <input type="text" class="form-control" id="parentPhone" name="parent_phone" required>
            </div>
            <div class="col-md-12">
              <label for="parentAddress" class="form-label">Address</label>
              <input type="text" class="form-control" id="parentAddress" name="parent_address">
            </div>
          </div>

          <hr>

          <h6 class="text-success mb-3">🎓 Student Information</h6>
          <div class="row">
            <div class="col-md-6">
              <label for="studentName" class="form-label">Student Name</label>
              <input type="text" class="form-control" id="studentName" name="student_name" required>
            </div>
            <div class="col-md-3">
              <label for="studentAge" class="form-label">Age</label>
              <input type="number" class="form-control" id="studentAge" name="student_age" required>
            </div>
            <div class="col-md-3">
              <label for="studentGender" class="form-label">Gender</label>
              <select class="form-select" id="studentGender" name="student_gender" required>
                <option value="">Select</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-6 mt-3">
              <label for="studentClass" class="form-label">Class</label>
              <input type="text" class="form-control" id="studentClass" name="student_class">
            </div>
            <div class="col-md-6 mt-3">
              <label for="enrollDate" class="form-label">Enrollment Date</label>
              <input type="date" class="form-control" id="enrollDate" name="enroll_date">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Registration</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
