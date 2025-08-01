<!-- Left Sidebar Start (Student View) -->
<div class="app-sidebar-menu">
  <div class="h-100" data-simplebar>
    <div id="sidebar-menu">

      <div class="logo-box text-center">
        <!-- Logo (Dark and Light) -->
        <a href="dashboard_student.php" class="logo logo-dark">
          <span class="logo-sm">
            <img src="../assets/images/logo.jpg" class="circle-logo" height="22">
          </span>
          <span class="logo-lg">
            <img src="../assets/images/logo.jpg" class="circle-logo" height="84">
          </span>
        </a>
        <a href="dashboard_student.php" class="logo logo-light">
          <span class="logo-sm">
            <img src="../assets/images/logo.jpg" class="circle-logo" height="22">
          </span>
          <span class="logo-lg">
            <img src="../assets/images/logo.jpg" class="circle-logo" height="84">
          </span>
        </a>
      </div>

      <ul id="side-menu" class="mt-4">

        <li class="menu-title">Student Dashboard</li>

        <li>
          <a href="dashboard.php">
            <i data-feather="home"></i> <span> Home </span>
          </a>
        </li>

        <li>
          <a href="#sidebarMyProfile" data-bs-toggle="collapse">
            <i data-feather="user"></i> <span> My Profile </span> <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarMyProfile">
            <ul class="nav-second-level">
              <li><a href="profile.php">View Profile</a></li>
              <li><a href="update-profile.php">Edit Profile</a></li>
              <li><a href="change-password.php">Change Password</a></li>
            </ul>
          </div>
        </li>

        <li>
          <a href="#sidebarMyExams" data-bs-toggle="collapse">
            <i data-feather="file-text"></i> <span> Exams </span> <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarMyExams">
            <ul class="nav-second-level">
              <li><a href="my-exams.php">Exam Schedule</a></li>
              <li><a href="my-results.php">My Results</a></li>
            </ul>
          </div>
        </li>

        <li>
          <a href="attendance.php">
            <i data-feather="calendar"></i> <span> Attendance </span>
          </a>
        </li>

        <li>
          <a href="announcements.php">
            <i data-feather="bell"></i> <span> Announcements </span>
          </a>
        </li>

        <li>
          <a href="report-card.php">
            <i data-feather="bar-chart-2"></i> <span> Report Card </span>
          </a>
        </li>

        <li>
          <a href="logout.php">
            <i data-feather="log-out"></i> <span> Logout </span>
          </a>
        </li>

      </ul>

    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- Left Sidebar End -->
