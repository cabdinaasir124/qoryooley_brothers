<?php
include '../config/conn.php';

$sql = "SELECT title, body, type, posted_by, created_at 
        FROM announcements 
        WHERE type = 'School' 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
  while ($row = $result->fetch_assoc()):
    ?>
    <div class="card shadow-sm border mt-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="fw-bold mb-1"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="text-muted mb-1">
              Posted by <?= htmlspecialchars($row['posted_by']) ?> | 
              <?= date('d M Y', strtotime($row['created_at'])) ?>
            </p>
            <p class="mb-0"><?= nl2br(htmlspecialchars($row['body'])) ?></p>
          </div>
          <div>
            <span class="badge bg-primary">School</span>
          </div>
        </div>
      </div>
    </div>
<?php
  endwhile;
else:
  echo '<div class="alert alert-warning">No school announcements found.</div>';
endif;

$conn->close();
?>
