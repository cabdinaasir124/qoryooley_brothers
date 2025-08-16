<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tajweed Records</title>
</head>
<body>
<div class="content-page">
  <div class="content">
    <div class="container-fluid">

<div class="container py-4">
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📖 Tajweed Records</h5>
      <button class="btn btn-primary" data-bs-target="#tajweedModal" data-bs-toggle="modal">
        <i class="fas fa-plus-circle"></i> Add Record
      </button>
    </div>
    <div class="card-body">
      <table id="tajweedTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Lesson</th>
            <th>Date</th>
            <th>Remarks</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="tajweedBody"></tbody>
      </table>
    </div>
  </div>

</div>



<div class="modal fade" id="tajweedUpdateModal" tabindex="-1">
  <div class="modal-dialog" id="TajweedUpdateModalBody">
   
  </div>
</div>

<div class="modal fade" id="tajweedModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="tajweedForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tajweedModalLabel">Add Tajweed Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id" name="id">
          <div class="mb-3">
            <label>Student Name</label>
            <input type="text" class="form-control" name="student_name" required>
          </div>
          <div class="mb-3">
            <label>Lesson</label>
            <input type="text" class="form-control" name="lesson" required>
          </div>
          <div class="mb-3">
            <label>Date</label>
            <input type="date" class="form-control" name="date" required>
          </div>
          <div class="mb-3">
            <label>Remarks</label>
            <textarea class="form-control" name="remarks"></textarea>
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


</body>
</html>
