
<!-- Left Sidebar Start -->
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">

            <!-- Logo -->
            <div class="logo-box">
                <a href="../Admin/" class="logo logo-light">
                    <span class="logo-sm"><img src="../assets/images/logo-sm.png" height="22"></span>
                    <span class="logo-lg"><img src="../assets/images/logo-light.png" height="24"></span>
                </a>
                <a href="../Admin/" class="logo logo-dark">
                    <span class="logo-sm"><img src="../assets/images/logo-sm.png" height="22"></span>
                    <span class="logo-lg"><img src="../assets/images/logo-dark.png" height="24"></span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Main</li>
                <li>
                    <a href="#sidebarDashboard" data-bs-toggle="collapse">
                        <i data-feather="home"></i> <span> Dashboard </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDashboard">
                        <ul class="nav-second-level">
                            <li><a href="dashboard.html">Main Dashboard</a></li>
                            <li><a href="stats.html">Statistics</a></li>
                            <li><a href="notifications.html">Notifications</a></li>
                        </ul>
                    </div>
                </li>

                <!-- ================================= -->
                <!-- FORMAL SCHOOL SECTION -->
                <!-- ================================= -->
                <li class="menu-title mt-2">Formal School</li>

                <li>
                    <a href="#sidebarStudents" data-bs-toggle="collapse">
                        <i data-feather="user"></i> <span> Students </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarStudents">
                        <ul class="nav-second-level">
                            <li><a href="../Admin/student_list.php">Student List</a></li>
                            <li><a href="student-profile.html">Student Profiles</a></li>
                            <li><a href="student-attendance.html">Student Attendance</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                <a href="#sidebarParents" data-bs-toggle="collapse">
                    <i data-feather="user-check"></i> <span> Parents </span> <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarParents">
                    <ul class="nav-second-level">
                        <li><a href="../Admin/parent_list.php">Parent List</a></li>
                        <!-- <li><a href="../Admin/register-parent.php">Register Parent</a></li> -->
                    </ul>
                </div>
            </li>


                <li>
                    <a href="#sidebarTeachers" data-bs-toggle="collapse">
                        <i data-feather="users"></i> <span> Teachers </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarTeachers">
                        <ul class="nav-second-level">
                            <li><a href="teachers.html">Teacher List</a></li>
                            <li><a href="register-teacher.html">Add Teacher</a></li>
                            <li><a href="teacher-profile.html">Teacher Profiles</a></li>
                            <li><a href="teacher-attendance.html">Teacher Attendance</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarSubjects" data-bs-toggle="collapse">
                        <i data-feather="book"></i> <span> Subjects </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSubjects">
                        <ul class="nav-second-level">
                            <li><a href="../Admin/subjects.php">Formal Subjects</a></li>
                            <!-- <li><a href="subject-categories.html">Subject Categories</a></li> -->
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarClasses" data-bs-toggle="collapse">
                        <i data-feather="layers"></i> <span> Classes </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarClasses">
                        <ul class="nav-second-level">
                            <li><a href="../Admin/class_list.php">Class List</a></li>
                            <!-- <li><a href="add-class.html">Add Class</a></li> -->
                            <li><a href="../Admin/c_schedule.php">Class Schedule</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarExams" data-bs-toggle="collapse">
                        <i data-feather="file-text"></i> <span> Exams </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarExams">
                        <ul class="nav-second-level">
                            <li><a href="exams.html">Exam List</a></li>
                            <li><a href="create-exam.html">Create Exam</a></li>
                            <li><a href="exam-results.html">Exam Results</a></li>
                        </ul>
                    </div>
                </li>

                <!-- ================================= -->
                <!-- QURANIC SCHOOL SECTION -->
                <!-- ================================= -->
                <li class="menu-title mt-2">Quranic School</li>

                <li>
                    <a href="#sidebarQuranic" data-bs-toggle="collapse">
                        <i data-feather="book-open"></i> <span> Quranic </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarQuranic">
                        <ul class="nav-second-level">
                            <li><a href="hifz.html">Hifz Progress</a></li>
                            <li><a href="tajweed.html">Tajweed Records</a></li>
                            <li><a href="teacher-halaqa-schedule.html"></i> <span> Halaqa Schedule </span></a></li>
                            <li><a href="quranic-subjects.html">Quranic Subjects</a></li>
                            <li><a href="quranic-teachers.html">Quranic Teachers</a></li>
                        </ul>
                    </div>
                </li>

                <!-- ================================= -->
                <!-- SHARED MODULES (BOTH) -->
                <!-- ================================= -->
                <li class="menu-title mt-2">Shared Modules</li>

                <li>
                    <a href="#sidebarAttendance" data-bs-toggle="collapse">
                        <i data-feather="calendar"></i> <span> Attendance </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAttendance">
                        <ul class="nav-second-level">
                            <li><a href="attendance.html">Daily Attendance</a></li>
                            <li><a href="monthly-attendance.html">Monthly Report</a></li>
                            <li><a href="attendance-summary.html">Summary</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarReports" data-bs-toggle="collapse">
                        <i data-feather="bar-chart-2"></i> <span> Reports </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarReports">
                        <ul class="nav-second-level">
                            <li><a href="reports.html">Report List</a></li>
                            <li><a href="student-reports.html">Student Reports</a></li>
                            <li><a href="teacher-reports.html">Teacher Reports</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarAnnouncements" data-bs-toggle="collapse">
                        <i data-feather="bell"></i> <span> Announcements </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAnnouncements">
                        <ul class="nav-second-level">
                            <li><a href="announcements.html">View All</a></li>
                            <li><a href="create-announcement.html">Add Announcement</a></li>
                            <li><a href="announcement-categories.html">Categories</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarSettings" data-bs-toggle="collapse">
                        <i data-feather="settings"></i> <span> Settings </span> <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings">
                        <ul class="nav-second-level">
                            <li><a href="settings.html">General Settings</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="../Admin/users.php">User Management</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="logout.html">
                        <i data-feather="log-out"></i> <span> Logout </span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->


