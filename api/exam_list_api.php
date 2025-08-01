<?php
// ../api/exam_list_api.php
include '../config/conn.php';

$sql = "SELECT e.*, c.class_name, a.year_name
        FROM exams e
        JOIN classes c ON e.class_id = c.id
        JOIN academic_years a ON e.academic_year_id = a.id
        ORDER BY e.date DESC";
$result = $conn->query($sql);

$i = 1;
$html = "";

while ($row = $result->fetch_assoc()) {
  $statusBadge = $row['status'] === 'published' ? 'bg-success' : 'bg-secondary';

  $html .= "<tr>
    <td>{$i}</td>
    <td>{$row['title']}</td>
    <td>{$row['class_name']}</td>
    <td>{$row['term']}</td>
    <td>{$row['date']}</td>
    <td><span class='badge {$statusBadge}'>" . ucfirst($row['status']) . "</span></td>
    <td>
      <a href='view-exam.php?id={$row['id']}' class='btn btn-sm btn-info'>View</a>
      <a href='edit-exam.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
      <a href='delete-exam.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
    </td>
  </tr>";

  $i++;
}

echo $html;
