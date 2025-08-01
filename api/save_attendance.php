<?php
include '../config/conn.php';

$class_id = intval($_POST['class_id']);
$date = $_POST['attendance_date'];
$attendance = $_POST['attendance'];

// Check if attendance already marked for all students in this class for the given date
$check_all = mysqli_query($conn, "
  SELECT COUNT(*) as total_marked
  FROM attendance a
  JOIN students s ON a.student_id = s.id
  WHERE s.class_id = $class_id AND a.date = '$date'
");

$marked_count = mysqli_fetch_assoc($check_all)['total_marked'];

// Get total students in the class
$get_total = mysqli_query($conn, "SELECT COUNT(*) as total_students FROM students WHERE class_id = $class_id");
$total_students = mysqli_fetch_assoc($get_total)['total_students'];

// If already fully marked, stop submission
if ($marked_count >= $total_students) {
  echo "<script>alert('⚠️ Attendance has already been marked for this class on $date.'); window.location.href='../content/attendance_sheet.php';</script>";
  exit;
}

// Proceed to insert or update attendance
foreach ($attendance as $student_id => $status) {
  $student_id = intval($student_id);
  $status = mysqli_real_escape_string($conn, $status);

  $check = mysqli_query($conn, "SELECT id FROM attendance WHERE student_id = $student_id AND date = '$date'");
  if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "UPDATE attendance SET status = '$status' WHERE student_id = $student_id AND date = '$date'");
  } else {
    mysqli_query($conn, "INSERT INTO attendance (student_id, date, status) VALUES ($student_id, '$date', '$status')");
  }
}

echo "<script>alert('✅ Attendance saved successfully!'); window.location.href='../admin/student-attendance.php';</script>";
?>
