<?php
include("../config/conn.php");

// Fetch classes based on academic_year_id
$classes = [];
if (isset($_GET['academic_year_id']) && is_numeric($_GET['academic_year_id'])) {
    $academic_year_id = intval($_GET['academic_year_id']);
    $query = "SELECT * FROM classes WHERE academic_year_id = $academic_year_id ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['days_active'] = json_decode($row['days_active'], true);
        $classes[] = $row;
    }
}
?>

<div class="card-body">
    <?php if (isset($_GET['academic_year_id'])): ?>
        <?php if (!empty($classes)): ?>
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
                <tbody></tbody> <!-- DataTables will fill this -->
            </table>
        <?php else: ?>
            <div class="alert alert-warning mt-3">No classes found for this academic year.</div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info mt-3">Please provide an academic year ID in the URL. Example: <code>?academic_year_id=1</code></div>
    <?php endif; ?>
</div>
