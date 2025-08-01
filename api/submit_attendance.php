<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include '../config/conn.php';
  $student_id = $_POST['student_id'];
  $date = $_POST['date'];
  $status = $_POST['status'];

  // Prevent duplicates
  $check = mysqli_query($conn, "SELECT * FROM attendance WHERE student_id='$student_id' AND date='$date'");
  if (mysqli_num_rows($check) == 0) {
    $insert = mysqli_query($conn, "INSERT INTO attendance (student_id, date, status) VALUES ('$student_id', '$date', '$status')");
    if ($insert) {
      echo "<script>alert('Attendance saved!');</script>";
    } else {
      echo "<script>alert('Error saving attendance.');</script>";
    }
  } else {
    echo "<script>alert('Attendance already exists for this student on this date.');</script>";
  }
}
?>
