<?php
require '../config/conn.php';
// Get academic year ID from URL
$academic_year_id = $_GET['academic_year_id'] ?? '';
?>
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
                                        <button id="btnAddStudent" class="btn btn-primary">
  <i class="fas fa-plus"></i>&nbsp;Add new student
</button>

                                    </div><!-- end card header -->

                                    <div class="card-body">
                                      <div class="mb-3 d-flex justify-content-end">
  <select id="classFilter" class="form-select w-100">
    <option value="">All Classes</option>
    <?php
      $classList = mysqli_query($conn, "SELECT id, class_name FROM classes ORDER BY class_name ASC");
      while ($c = mysqli_fetch_assoc($classList)) {
          echo "<option value='{$c['class_name']}'>{$c['class_name']}</option>";
      }
    ?>
  </select>
</div>

                                       <table id="studentTable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>student ID</th>
                                            <th>Student Name</th>
                                            <th>Class</th>
                                            <th>Parent Name</th>
                                            <th>view more</th>
                                            <!-- <th>update</th> -->
                                            <!-- <th>delete</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example static row (replace with PHP or JS dynamic later) -->
                                           
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
  </div>

<!-- Student Registration Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="studentForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Register Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <!-- Left Column -->
            <div class="col-md-6">
              <div class="mb-2">
<input type="hidden" name="academic_year_id" id="academic_year_hidden" value="<?= $academic_year_id ?>">
<input type="hidden" name="id" id="student_db_id">

                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" id="student_id" name="student_id" class="form-control" readonly>
              </div>

              <div class="mb-2">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
              </div>

              <div class="mb-2">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select" required>
                  <option value="">-- Select --</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <div class="mb-2">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" id="dob" class="form-control">
              </div>

              <div class="mb-2">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <input type="text" name="place_of_birth" id="place_of_birth" class="form-control">
              </div>

              <div class="mb-2">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="2"></textarea>
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
              <!-- Class Dropdown -->
            <div class="mb-2">
              <label for="class_id" class="form-label">Class</label>
              <select name="class_id" id="class_id" class="form-select" required>
                <?php
                  include '../config/conn.php'; // ✅ Make sure this is included
                  $classes = mysqli_query($conn, "SELECT id, class_name FROM classes ORDER BY class_name ASC");
                  while ($c = mysqli_fetch_assoc($classes)) {
                      echo "<option value='{$c['id']}'>{$c['class_name']}</option>";
                  }
                ?>
              </select>
            </div>
              <!-- Academic Year Dropdown -->
              <div class="mb-2">
                <label for="academic_year_id" class="form-label">Academic Year</label>
                <select name="academic_year_id" id="academic_year_id" class="form-select" required>
                  <?php
include '../config/conn.php';

$query = "SELECT id, year_name FROM academic_years ORDER BY id ASC";
$years = mysqli_query($conn, $query);

if (!$years) {
    echo "<option disabled>Error loading academic years: " . mysqli_error($conn) . "</option>";
} else {
    while ($y = mysqli_fetch_assoc($years)) {
        echo "<option value='{$y['id']}'>{$y['year_name']}</option>";
    }
}
?>

                </select>
              </div>

              <div class="mb-2">
                <label for="parent_id" class="form-label">Parent</label>
                <select name="parent_id" id="parent_id" class="form-select">
                  <?php
                    $parents = mysqli_query($conn, "SELECT id, name FROM parents ORDER BY name ASC");
                    while($p = mysqli_fetch_assoc($parents)){
                      echo "<option value='{$p['id']}'>{$p['name']}</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="mb-2">
                <label for="student_image" class="form-label">Student Image</label>
                <input type="file" name="student_image" id="student_image" class="form-control">
              </div>

              <div class="mb-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Graduated">Graduated</option>
                  <option value="Left">Left</option>
                </select>
              </div>

              <div class="mb-2">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add Student</button>
        </div>
      </div>
    </form>
  </div>
</div>




<!-- View Student Modal -->
<div class="modal fade" id="viewStudentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Student Details</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="studentInfoTable">
        <!-- Image and table rows will be injected here -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



