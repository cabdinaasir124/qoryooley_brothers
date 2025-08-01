<?php
include '../config/conn.php';

$sql = "SELECT 
    a.date, s.full_name, a.status 
  FROM attendance a 
  JOIN students s ON a.student_id = s.id 
  ORDER BY a.date DESC 
  LIMIT 5";

$result = mysqli_query($conn, $sql);
$output = "";

if (mysqli_num_rows($result) > 0) {
  $output .= "<ul class='list-group'>";
  while ($row = mysqli_fetch_assoc($result)) {
    $badge = $row['status'] === 'Present' 
      ? "<span class='badge bg-success'>Present</span>" 
      : "<span class='badge bg-danger'>Absent</span>";

    $output .= "<li class='list-group-item d-flex justify-content-between align-items-center'>
                  {$row['full_name']} - {$row['date']}
                  $badge
                </li>";
  }
  $output .= "</ul>";
} else {
  $output = "<p class='text-muted'>No recent attendance data.</p>";
}

echo $output;
?>
