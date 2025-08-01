<?php
include '../../config/conn.php';

$class_id = intval($_GET['class_id']);
$students = mysqli_query($conn, "SELECT id, full_name FROM students WHERE class_id = $class_id");

if (mysqli_num_rows($students) == 0) {
  echo "<div style='padding: 10px; background: #ffeeba; border: 1px solid #f0ad4e; border-radius: 4px;'>⚠️ No students found in this class.</div>";
  exit;
}
?>



<table id="studentsTable" class="table table-bordered table-striped mt-3">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Student Name</th>
      <th>Present</th>
      <th>Absent</th>
      <th>Leave</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    while ($row = mysqli_fetch_assoc($students)) {
      $id = $row['id'];
      echo "<tr>
              <td>{$i}</td>
              <td>{$row['full_name']}</td>
              <td><input type='radio' name='attendance[{$id}]' value='Present' required></td>
              <td><input type='radio' name='attendance[{$id}]' value='Absent'></td>
              <td><input type='radio' name='attendance[{$id}]' value='Leave'></td>
            </tr>";
      $i++;
    }
    ?>
  </tbody>
</table>

<!-- DataTables Initialization -->
<script>
  setTimeout(() => {
    const table = new DataTable('#studentsTable', {
      paging: false,
      info: false,
      searching: false,
      ordering: false,
      responsive: true
    });
  }, 100);
</script>
