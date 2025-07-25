<?php
require '../config/conn.php';

// Get academic year ID from URL
$academic_year_id = $_GET['academic_year_id'] ?? '';
?>
<!-- Schedule List Page -->
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
      <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">Class Schedules</h5>
          <button class="btn btn-primary" onclick="openAddScheduleModal()">+ Add Schedule</button>
          
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
  <div>
    <label for="filter_class_id" class="form-label fw-bold">Filter by Class:</label>
    <select id="filter_class_id" class="form-select" style="width: 200px;">
      <option value="">-- All Classes --</option>
      <?php
        $classes = $conn->query("SELECT id, class_name FROM classes WHERE academic_year_id = '$academic_year_id'");
        while ($cls = $classes->fetch_assoc()):
      ?>
        <option value="<?= $cls['id'] ?>"><?= $cls['class_name'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <button id="printSchedule" class="btn btn-secondary align-self-end">🖨️ Print Schedule</button>
</div>

          <table id="scheduleTable" class="table table-bordered table-striped display responsive nowrap w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Day</th>
                <th>Start</th>
                <th>End</th>
                <th>Teacher</th>
                <th>Room</th>
                <th>Status</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add/Edit Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
  <div class="modal-dialog modal-lg"> <!-- Made it large -->
    <form id="scheduleForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

      <div class="modal-body">
  <input type="hidden" name="id" id="schedule_id">
  <input type="hidden" name="academic_year_id" value="<?= htmlspecialchars($academic_year_id) ?>">

  <div class="row mb-2">
    <div class="col-md-6">
      <label>Class</label>
      <select name="class_id" id="schedule_class_id" class="form-select">
        <option value="">-- Select Class --</option>
        <?php
          $classes = $conn->query("SELECT id, class_name FROM classes WHERE academic_year_id = '$academic_year_id'");
          while ($cls = $classes->fetch_assoc()):
        ?>
        <option value="<?= $cls['id'] ?>"><?= $cls['class_name'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label>Subject</label>
      <select name="subject_id" id="schedule_subject_id" class="form-select">
        <option value="">-- Select Subject --</option>
      </select>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-6">
      <label>Day of Week</label>
      <select name="day_of_week" id="day_of_week" class="form-select">
        <option value="">-- Select Day --</option>
        <?php foreach (['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day): ?>
          <option value="<?= $day ?>"><?= $day ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label>Start Time</label>
      <input type="time" name="start_time" id="start_time" class="form-control">
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-6">
      <label>End Time</label>
      <input type="time" name="end_time" id="end_time" class="form-control">
    </div>

    <div class="col-md-6">
      <label>Teacher Name</label>
      <input type="text" name="teacher_name" id="teacher_name" class="form-control" placeholder="Teacher Name">
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-6">
      <label>Room</label>
      <input type="text" name="room" id="room" class="form-control" placeholder="Room (optional)">
    </div>

    <div class="col-md-6">
      <label>Status</label>
      <select name="status" id="schedule_status" class="form-select">
        <option value="">-- Select Status --</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
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

