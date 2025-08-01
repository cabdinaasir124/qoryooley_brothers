<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <!-- Page Title -->
      <div class="row mt-4">
        <div class="col">
          <h4 class="page-title">📢 Announcements</h4>
          <p class="text-muted">View announcements across all roles: School and Qur’anic Systems</p>
        </div>
      </div>

      <!-- Tabs -->
      <ul class="nav nav-tabs nav-bordered mb-3" id="announcementTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="school-tab" data-bs-toggle="tab" href="#school" role="tab">School</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="quran-tab" data-bs-toggle="tab" href="#quran" role="tab">Qur’an</a>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content" id="announcementTabsContent">

        <!-- All Announcements -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
          <?php include 'announcement_all.php'; ?>
        </div>

        <!-- School Announcements -->
        <div class="tab-pane fade" id="school" role="tabpanel">
          <?php include 'announcement_school.php'; ?>
        </div>

        <!-- Quran Announcements -->
        <div class="tab-pane fade" id="quran" role="tabpanel">
          <?php include 'announcement_quran.php'; ?>
        </div>

      </div>

    </div>
  </div>
</div>
