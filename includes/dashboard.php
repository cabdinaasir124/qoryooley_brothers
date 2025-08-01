 <?php
 include '../config/conn.php'; // Adjust the path to your DB config

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = "Good Afternoon";
} elseif ($hour >= 17 && $hour < 21) {
    $greeting = "Good Evening";
} else {
    $greeting = "Good Night";
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';


$sql = "SELECT 
    s.id,
    s.student_id,
    s.full_name,
    s.student_image,
    s.created_at,
    c.class_name
FROM 
    students s
JOIN 
    classes c ON s.class_id = c.id
ORDER BY 
    s.created_at DESC
LIMIT 5;
";


$result = $conn->query($sql);



// Total students
$students_count = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];

// Total parents
$parents_count = $conn->query("SELECT COUNT(*) as total FROM parents")->fetch_assoc()['total'];

// Total classes
$classes_result = $conn->query("SELECT class_name, COUNT(*) as count FROM students 
JOIN classes ON students.class_id = classes.id 
GROUP BY class_name");

$class_data = [];
$total_class_students = 0;
while ($row = $classes_result->fetch_assoc()) {
    $class_data[] = [
        'name' => $row['class_name'],
        'count' => $row['count']
    ];
    $total_class_students += $row['count'];
}

// Total active teachers (example, update with your real table)
$teachers_count = 42; // Placeholder. Replace with dynamic query if needed

// Sample subject count
$subjects_count = $conn->query("SELECT COUNT(*) as total FROM subjects")->fetch_assoc()['total'];

// Attendance percentage today (example)
$today = date('Y-m-d');
$att_result = $conn->query("SELECT 
    (SELECT COUNT(*) FROM attendance WHERE date = '$today' AND status = 'present') AS present,
    (SELECT COUNT(*) FROM attendance WHERE date = '$today') AS total");

$att_data = $att_result->fetch_assoc();
$attendance_percentage = ($att_data['total'] > 0) ? round(($att_data['present'] / $att_data['total']) * 100, 1) : 0;

?>

<style>
    .bg-light-pink {
    background-color: #fce4ec;
}
.text-pink {
    color: #ec407a;
}

.bg-light-blue {
    background-color: #e3f2fd;
}
.text-blue {
    color: #42a5f5;
}

.bg-light-danger {
    background-color: #fdecea;
}
.text-danger {
    color: #e53935;
}

.bg-light-secondary {
    background-color: #f3f4f6;
}
.text-secondary {
    color: #6c757d;
}

</style>

 <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
    <h5 class="mb-0">Welcome Back <?php echo htmlspecialchars($username); ?></h5>
    </div>
</div>


<!-- Start Row -->
<div class="row">
    <div class="col-md-12">
        <div class="row">

            <!-- Total Students -->
            <div class="col-md-6 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex align-items-center mb-1">
                                <span class="avatar-md rounded-circle bg-gray d-flex justify-content-center align-items-center me-3">
                                    <i class="fas fa-user-graduate text-primary fs-4"></i>
                                </span>
                                <div>
                                    <p class="mb-2 text-dark fs-15 fw-medium">Total Students</p>
                                    <h3 class="mb-0 fs-22 text-dark me-3" id="studentCount">Loading...</h3>
                                </div>
                            </div>
                            <!-- <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1 fs-14 fw-medium">This Month</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+3.2%</span>
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Classes -->
            <div class="col-md-6 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex align-items-center mb-1">
                                <span class="avatar-md rounded-circle bg-gray d-flex justify-content-center align-items-center me-3">
                                    <i class="fas fa-chalkboard-teacher text-success fs-4"></i>
                                </span>
                                <div>
                                    <p class="mb-2 text-dark fs-15 fw-medium">ongoing Classes</p>
                                    <h3 class="mb-0 fs-22 text-dark me-3" id="classCount">Loading...</h3>
                                </div>
                            </div>
                            <!-- <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">Today</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+5.6%</span>
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registered Teachers -->
            <div class="col-md-6 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex align-items-center mb-1">
                                <span class="avatar-md rounded-circle bg-gray d-flex justify-content-center align-items-center me-3">
                                    <i class="fas fa-users text-warning fs-4"></i>
                                </span>
                                <div>
                                    <p class="mb-2 text-dark fs-15 fw-medium">Teachers</p>
                                    <h3 class="mb-0 fs-22 text-dark me-3" id="countTeacher">loading..</h3>
                                </div>
                            </div>
                            <!-- <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">This Week</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-danger px-2 py-1 bg-danger-subtle rounded-4">-1.2%</span>
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exams Scheduled -->
            <div class="col-md-6 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex align-items-center mb-1">
                                <span class="avatar-md rounded-circle bg-gray d-flex justify-content-center align-items-center me-3">
                                    <i class="fas fa-file-alt text-info fs-4"></i>
                                </span>
                                <div>
                                    <p class="mb-2 text-dark fs-15 fw-medium">Upcoming Exams</p>
                                    <h3 class="mb-0 fs-22 text-dark me-3">12</h3>
                                </div>
                            </div>
                            <!-- <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">This Month</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+2.8%</span>
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
       <div class="row">
    <!-- Girls -->
    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <span class="avatar-md rounded-circle bg-light-pink d-flex justify-content-center align-items-center me-3">
                        <i class="fas fa-female text-pink fs-4"></i>
                    </span>
                    <div>
                        <p class="mb-2 text-dark fs-15 fw-medium">Total Girls</p>
                        <h3 class="mb-0 fs-22 text-dark me-3" id="girlCount">Loading...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Boys -->
    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <span class="avatar-md rounded-circle bg-light-blue d-flex justify-content-center align-items-center me-3">
                        <i class="fas fa-male text-blue fs-4"></i>
                    </span>
                    <div>
                        <p class="mb-2 text-dark fs-15 fw-medium">Total Boys</p>
                        <h3 class="mb-0 fs-22 text-dark me-3" id="boyCount">Loading...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses -->
    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <span class="avatar-md rounded-circle bg-light-danger d-flex justify-content-center align-items-center me-3">
                        <i class="fas fa-money-bill-wave text-danger fs-4"></i>
                    </span>
                    <div>
                        <p class="mb-2 text-dark fs-15 fw-medium">Monthly Expenses</p>
                        <h3 class="mb-0 fs-22 text-dark me-3" id="expenseTotal">$0.00</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Activities -->
    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <span class="avatar-md rounded-circle bg-light-secondary d-flex justify-content-center align-items-center me-3">
                        <i class="fas fa-tasks text-secondary fs-4"></i>
                    </span>
                    <div>
                        <p class="mb-2 text-dark fs-15 fw-medium">Other Activities</p>
                        <h3 class="mb-0 fs-22 text-dark me-3" id="otherActivities">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    </div>
</div>
<!-- End Row -->


                  
<!-- Dashboard Section: Student Enrollment Chart + Tasks -->
<div class="row">
  <!-- Student Enrollment Overview -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Student Enrollment Overview</h5>
      </div>
      <div class="card-body">
        <div id="student-statistics" class="apex-charts" style="height: 360px;"></div>
      </div>
    </div>
  </div>

  <!-- Upcoming Events & Tasks -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Upcoming Events & Tasks</h5>
      </div>
      <div class="card-body">
        <ul class="list-unstyled task-list-tab mb-0" id="taskList"></ul>
      </div>
    </div>
  </div>
</div>

<!-- Start Projects Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">Recently Registered Students</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                           <h5 class="card-title mb-0"></h5>

<table class="table table-traffic mb-0">
    <thead>
        <tr>
            <th>No</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Admission No</th>
            <th>Class</th>
            <th>Registration Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                $imagePath = !empty($row['student_image']) 
                    ? '' . $row['student_image'] 
                    : '../assets/images/default-user.png';

                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td><img src="' . $imagePath . '" width="40" height="40" class="rounded-circle" alt="Photo"></td>';
                echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['student_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['class_name']) . '</td>';
                echo '<td>' . date('d M Y', strtotime($row['created_at'])) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No students found</td></tr>';
        }
        $result->free();
        $conn->close();
        ?>
    </tbody>
</table>

                        </div>
                    </div>

                    <div class="card-footer py-0 border-top">
                        <div class="row align-items-center">
                            <div class="col-sm">
                                <div class="text-block text-center text-sm-start">
                                    <span class="fw-medium">1 of 3</span>
                                </div>
                            </div>
                            <div class="col-sm-auto mt-3 mt-sm-0">
                                <div class="pagination gap-2 justify-content-center py-3 ps-0 pe-3">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link me-2 rounded-2" href="javascript:void(0);">
                                                Prev </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link rounded-2 me-2" href="#" data-i="1"
                                                data-page="5">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link me-2 rounded-2" href="#" data-i="2"
                                                data-page="5">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-primary rounded-2"
                                                href="javascript:void(0);"> next </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Projects Summary -->

                    <!-- Start School and Qur'an System Overview -->
<div class="row">

    <!-- School Categories & Statistics -->
    <!-- School Categories & Statistics -->
<div class="col-md-6 col-xl-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
            <h5 class="card-title mb-0">Class Breakdown</h5>
            </div>
        </div>

        <div class="card-body">
            <div class="row align-items-center">

                <div class="col align-items-center">
                    <div id="project-categories" class="apex-charts"></div>
                </div>

                <div class="col">
                    <?php foreach ($class_data as $class): 
                        $percent = $total_class_students > 0 
                            ? round(($class['count'] / $total_class_students) * 100, 1) 
                            : 0;
                        $color = '#' . substr(md5($class['name']), 0, 6); // random consistent color
                    ?>
                        <div class="d-flex justify-content-between align-items-center p-1">
                            <div>
                                <i class="mdi mdi-circle fs-12 align-middle me-1" style="color: <?= $color ?>"></i>
                                <span class="align-middle fw-semibold"><?= htmlspecialchars($class['name']) ?></span>
                            </div>
                            <span class="fw-medium text-muted float-end">
                                <i class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>
                                <?= $percent ?>%
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row row-cols-12 border border-dashed border-1 rounded-2 mt-2">
                <div class="col">
                    <div class="p-2 border-end border-inline-end-dashed">
                        <p class="mb-1 text-muted text-start">Students Enrolled</p>
                        <div class="d-flex align-items-center mt-2 justify-content-between me-2">
                            <h3 class="mb-0 fs-22 text-dark me-3"><?= $students_count ?></h3>
                            <span class="text-primary fs-14">
                                <i class="mdi mdi-trending-up fs-14"></i> <?= rand(3, 10) ?>%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="p-2 ps-0">
                        <p class="mb-1 text-muted text-start">Active Teachers</p>
                        <div class="d-flex align-items-center mt-2 justify-content-between">
                            <h3 class="mb-0 fs-22 text-dark me-3"><?= $teachers_count ?></h3>
                            <span class="text-primary fs-14">
                                <i class="mdi mdi-trending-up fs-14"></i> <?= rand(2, 8) ?>%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


    <!-- School Budget -->
    <div class="col-md-6 col-xl-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0">Monthly Budget</h5>
                </div>
            </div>
            <div class="card-body">
                <div id="project_budget" class="apex-charts"></div>
            </div>
        </div>
    </div>

    <!-- Task Overview -->
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0">Task Overview</h5>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush list-group-no-gutters">

                    <!-- Example Tasks -->
                    <li class="list-group-item px-0 pt-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <span class="avatar rounded-3 avatar-sm bg-light d-flex align-items-center justify-content-center">
                                    📚
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark fs-15">Book Purchase</h6>
                                <p class="fs-13 text-muted mb-0">Library & Qur’an books</p>
                            </div>
                            <div class="ms-auto text-end">
                                <span class="h6 mb-0 fw-semibold text-danger">-$220</span>
                                <span class="d-block text-muted fs-13">July 10, 2024</span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item px-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <span class="avatar rounded-3 avatar-sm bg-light d-flex align-items-center justify-content-center">
                                    👨‍🏫
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark fs-15">Teacher Salary</h6>
                                <p class="fs-13 text-muted mb-0">Monthly payout</p>
                            </div>
                            <div class="ms-auto text-end">
                                <span class="h6 mb-0 fw-semibold text-danger">-$1,250</span>
                                <span class="d-block text-muted fs-13">July 1, 2024</span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item px-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <span class="avatar rounded-3 avatar-sm bg-light d-flex align-items-center justify-content-center">
                                    💰
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark fs-15">Student Fees</h6>
                                <p class="fs-13 text-muted mb-0">Income</p>
                            </div>
                            <div class="ms-auto text-end">
                                <span class="h6 mb-0 fw-semibold text-success">+$3,600</span>
                                <span class="d-block text-muted fs-13">July 5, 2024</span>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item px-0 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <span class="avatar rounded-3 avatar-sm bg-light d-flex align-items-center justify-content-center">
                                    🧾
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark fs-15">Maintenance</h6>
                                <p class="fs-13 text-muted mb-0">Repairs & utilities</p>
                            </div>
                            <div class="ms-auto text-end">
                                <span class="h6 mb-0 fw-semibold text-danger">-$480</span>
                                <span class="d-block text-muted fs-13">July 6, 2024</span>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

</div>
<!-- End School and Qur'an System Overview -->


        

        </div> <!-- container-fluid -->
    </div> <!-- content -->

            

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
         