<div class="content-page">
  <div class="content">
    <div class="container-fluid">
<div class="card mt-4">
  <div class="card-header"><h5>Add New Announcement</h5></div>
  <div class="card-body">
    <form method="POST" action="../api/save_announcement.php">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

    <div class="mb-3">
  <label class="form-label">Audience</label><br>
  <?php
  $audiences = [
    'all' => 'All',
    'student' => 'Student',
    'teachers' => 'Teachers',
    'parents' => 'Parents',
    'admin' => 'Admin'
  ];
  foreach ($audiences as $value => $label):
?>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="target_audience" value="<?= $value; ?>" <?= $value === 'all' ? 'checked' : '' ?>>
    <label class="form-check-label"><?= $label; ?></label>
  </div>
<?php endforeach; ?>

</div>


      <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
          <option value="both">Both School & Quran</option>
          <option value="school">School</option>
          <option value="quran">Qur’an</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="body" class="form-control" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Post Announcement</button>
    </form>
  </div>
</div>
    </div>
    </div>
</div>
