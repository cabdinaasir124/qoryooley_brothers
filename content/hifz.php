<?php
// hifz_list.php
include '../config/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hifz Progress</title>
</head>
<body>

<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <div class="container mt-4">
        <div class="card p-3">
          <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Hifz List</h5>
            <button class="btn btn-primary" id="addNewBtn" data-bs-toggle="modal" data-bs-target="#hifzModal">
              <i class="fas fa-plus"></i>&nbsp;Add Hifz Progress
            </button>
          </div>
        <table id="hifzTable" class="table table-striped table-bordered" style="width:100%">
  <thead class="table-primary">
    <tr>
      <th>Student Name</th>
      <th>Juz Completed</th>
      <th>Last Surah</th>
      <th>Revision Notes</th>
      <th>created data</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- JS will inject rows here -->
  </tbody>
</table>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add New Hifz Modal -->
<div class="modal fade" id="hifzModal" tabindex="-1" aria-labelledby="hifzModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="hifzModalLabel">Add Hifz Progress</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="hifzForm">
          <div class="mb-3">
            <label for="student_id" class="form-label">Student Name</label><br>
            <select id="student_id" name="student_id" class="form-select" required>
              <option value="">Select Student</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="juz_completed" class="form-label">Juz Completed</label>
            <input type="number" id="juz_completed" name="juz_completed" class="form-control" min="1" max="30" required>
          </div>
          <div class="mb-3">
            <label for="last_surah" class="form-label">Last Surah</label>
            <input type="text" id="last_surah" name="last_surah" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="revision_notes" class="form-label">Revision Notes</label>
            <textarea id="revision_notes" name="revision_notes" class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-success w-100">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Update New Hifz Modal -->
<div class="modal fade" id="updatehifzModal" tabindex="-1" aria-labelledby="updatehifzModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="updatehifzModalLabel">Update Hifz Progress</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="UpdateHifzBody">
       <!-- will be js File -->
      </div>
    </div>
  </div>
</div>


</body>
</html>
