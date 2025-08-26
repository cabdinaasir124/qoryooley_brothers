<?php
// session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$permissions = $_SESSION['permissions'] ?? [];

function show_if_permission($perm) {
    global $permissions;
    return in_array($perm, $permissions);
}
?>

<style>
.circle-logo {
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin: 10px auto;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
.logo-sm .circle-logo { width: 40px; height: 40px; }
.logo-lg .circle-logo { width: 80px; height: 80px; }
</style>

<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">

            <div class="logo-box text-center">
                <a href="../Admin/" class="logo logo-dark">
                    <span class="logo-sm"><img src="../assets/images/logo.jpg" class="circle-logo" height="22"></span>
                    <span class="logo-lg"><img src="../assets/images/logo.jpg" class="circle-logo" height="84"></span>
                </a>
                <a href="../Admin/" class="logo logo-light">
                    <span class="logo-sm"><img src="../assets/images/logo.jpg" class="circle-logo" height="22"></span>
                    <span class="logo-lg"><img src="../assets/images/logo.jpg" class="circle-logo" height="84"></span>
                </a>
            </div>

            <ul id="side-menu">

                <!-- Main Dashboard -->
                <?php if(show_if_permission('dashboard')): ?>
                    <li class="menu-title">Main</li>
                    <li>
                        <a href="#sidebarDashboard" data-bs-toggle="collapse">
                            <i data-feather="home"></i> <span> Dashboard </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarDashboard">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('dashboard_main')): ?>
                                    <li><a href="dashboard.html">Main Dashboard</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('dashboard_stats')): ?>
                                    <li><a href="stats.html">Statistics</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('dashboard_notifications')): ?>
                                    <li><a href="notifications.html">Notifications</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Formal School -->
                <?php if(
                    show_if_permission('students') || show_if_permission('parents') || 
                    show_if_permission('teachers') || show_if_permission('subjects') || 
                    show_if_permission('classes') || show_if_permission('exams') || 
                    show_if_permission('finance')
                ): ?>
                    <li class="menu-title mt-2">Formal School</li>
                <?php endif; ?>

                <!-- Students -->
                <?php if(show_if_permission('students')): ?>
                    <li>
                        <a href="#sidebarStudents" data-bs-toggle="collapse">
                            <i data-feather="user"></i> <span> Students </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarStudents">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('student_list')): ?>
                                    <li><a href="../Admin/student_list.php">Student List</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('student_id')): ?>
                                    <li><a href="../Admin/student_id.php">Student ID-card</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('leave_cert')): ?>
                                    <li><a href="../Admin/leave_cert.php">Leave certificate</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('student_attendance')): ?>
                                    <li><a href="../Admin/student-attendance.php">Student Attendance</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Parents -->
                <?php if(show_if_permission('parents')): ?>
                    <li>
                        <a href="#sidebarParents" data-bs-toggle="collapse">
                            <i data-feather="user-check"></i> <span> Parents </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarParents">
                            <ul class="nav-second-level">
    <?php if(show_if_permission('formal_subjects')): ?>
        <li><a href="../Admin/subjects.php">Formal Subjects</a></li>
    <?php endif; ?>
</ul>

                        </div>
                    </li>
                <?php endif; ?>

                <!-- Teachers -->
                <?php if(show_if_permission('teachers')): ?>
                    <li>
                        <a href="#sidebarTeachers" data-bs-toggle="collapse">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Teachers</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarTeachers">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('teacher_list')): ?>
                                    <li><a href="../admin/teacher.php">Teacher List</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('teacher_profiles')): ?>
                                    <li><a href="../admin/teacher-profile.php">Teacher Profiles</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('teacher_attendance')): ?>
                                    <li><a href="../admin/teacher-attendance.php">Teacher Attendance</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Subjects -->
                <?php if(show_if_permission('subjects')): ?>
                    <li>
                        <a href="#sidebarSubjects" data-bs-toggle="collapse">
                            <i data-feather="book"></i> <span> Subjects </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarSubjects">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('formal_subjects')): ?>
                                    <li><a href="../Admin/subjects.php">Formal Subjects</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Finance -->
                <?php if(show_if_permission('finance')): ?>
                    <li>
                        <a href="#sidebarFinance" data-bs-toggle="collapse">
                            <i data-feather="dollar-sign"></i> <span> Finance </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarFinance">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('expense_list')): ?>
                                    <li><a href="../admin/expenses.php">Expense List</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Classes -->
                <?php if(show_if_permission('classes')): ?>
                    <li>
                        <a href="#sidebarClasses" data-bs-toggle="collapse">
                            <i data-feather="layers"></i> <span> Classes </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarClasses">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('class_list')): ?>
                                    <li><a href="../Admin/class_list.php">Class List</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('class_schedule')): ?>
                                    <li><a href="../Admin/c_schedule.php">Class Schedule</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Exams -->
                <?php if(show_if_permission('exams')): ?>
                    <li>
                        <a href="#sidebarExams" data-bs-toggle="collapse">
                            <i data-feather="file-text"></i> <span> Exams </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarExams">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('all_exams')): ?>
                                    <li><a href="../Admin/exam.php">All Exams</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('exam_timetable')): ?>
                                    <li><a href="../Admin/exam-schedule.php">Exam Timetable</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('exam_subjects')): ?>
                                    <li><a href="../Admin/exam_subjects.php">Exam Subjects</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('marks_entry')): ?>
                                    <li><a href="../Admin/exam-results.php">Marks Entry</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('results_overview')): ?>
                                    <li><a href="../Admin/exam-result-view.php">Results Overview</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Quranic School -->
                <?php if(show_if_permission('quranic')): ?>
                    <li class="menu-title mt-2">Quranic School</li>
                    <li>
                        <a href="#sidebarQuranic" data-bs-toggle="collapse">
                            <i data-feather="book-open"></i> <span> Quranic </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarQuranic">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('hifz_progress')): ?>
                                    <li><a href="../Admin/hifz.php">Hifz Progress</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('halaqa_schedule')): ?>
                                    <li><a href="../Admin/halaqa-schedule.php">Halaqa Schedule</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('tajweed_records')): ?>
                                    <li><a href="../Admin/tajweed.php">Tajweed Records</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Shared Modules -->
                <?php if(show_if_permission('attendance')): ?>
                    <li>
                        <a href="#sidebarAttendance" data-bs-toggle="collapse">
                            <i data-feather="calendar"></i> <span> Attendance </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAttendance">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('daily_attendance')): ?>
                                    <li><a href="../Admin/daily-attendance.php">Daily Attendance</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('monthly_report')): ?>
                                    <li><a href="../Admin/monthly-attendance.php">Monthly Report</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('teachers_attendance')): ?>
                                    <li><a href="../Admin/attendance-summary.php">Teachers attendance</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(show_if_permission('reports')): ?>
                    <li>
                        <a href="#sidebarReports" data-bs-toggle="collapse">
                            <i data-feather="bar-chart-2"></i> <span> Reports </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarReports">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('report_list')): ?>
                                    <li><a href="reports.html">Report List</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('student_reports')): ?>
                                    <li><a href="student-reports.html">Student Reports</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('teacher_reports')): ?>
                                    <li><a href="teacher-reports.html">Teacher Reports</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(show_if_permission('announcements')): ?>
                    <li>
                        <a href="#sidebarAnnouncements" data-bs-toggle="collapse">
                            <i data-feather="bell"></i> <span> Announcements </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAnnouncements">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('announcements_list')): ?>
                                    <li><a href="../admin/announcements.php">Announcements list</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('add_announcement')): ?>
                                    <li><a href="../admin/create_announcements.php">Add Announcement</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(show_if_permission('settings')): ?>
                    <li>
                        <a href="#sidebarSettings" data-bs-toggle="collapse">
                            <i data-feather="settings"></i> <span> Settings </span> <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarSettings">
                            <ul class="nav-second-level">
                                <?php if(show_if_permission('general_settings')): ?>
                                    <li><a href="settings.html">General Settings</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('profile')): ?>
                                    <li><a href="profile.html">Profile</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('assign_permission')): ?>
                                    <li><a href="../Admin/permission.php">Assign Permission</a></li>
                                <?php endif; ?>
                                <?php if(show_if_permission('user_management')): ?>
                                    <li><a href="../Admin/users.php">User Management</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
