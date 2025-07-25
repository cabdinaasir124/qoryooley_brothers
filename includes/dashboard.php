 <?php
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



?>



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
                                    <h3 class="mb-0 fs-22 text-dark me-3">1,250</h3>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1 fs-14 fw-medium">This Month</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+3.2%</span>
                                </p>
                            </div>
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
                                    <p class="mb-2 text-dark fs-15 fw-medium">Active Classes</p>
                                    <h3 class="mb-0 fs-22 text-dark me-3">32</h3>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">Today</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+5.6%</span>
                                </p>
                            </div>
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
                                    <h3 class="mb-0 fs-22 text-dark me-3">58</h3>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">This Week</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-danger px-2 py-1 bg-danger-subtle rounded-4">-1.2%</span>
                                </p>
                            </div>
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
                            <div class="d-flex align-items-center mt-3 justify-content-between">
                                <p class="mb-0 text-dark mt-1">This Month</p>
                                <p class="text-muted mb-0 fs-13">
                                    <span class="text-success px-2 py-1 bg-success-subtle rounded-4">+2.8%</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->


                    <!-- Start Project Statistics -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
<h5 class="card-title mb-0">Student Enrollment Overview</h5>
<div id="school-quran-statistics" class="apex-charts"></div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="project-statistics" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">

                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
<h5 class="card-title mb-0">Upcoming Events & Tasks</h5>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <ul class="list-unstyled task-list-tab mb-0">

                                        <li>
                                            <div class="d-flex mb-2 pb-1">
                                                <div class="form-check  me-2">
                                                    <input type="checkbox" class="form-check-input">
                                                </div>
                                                <div class="flex-fill w-100">
                                                    <div class="d-flex align-items-start justify-content-between gap-1">
                                                        <div>
                                                            <h6 class="d-block fw-medium mb-1 text-dark fs-15">Prepare Midterm Exam Papers</h6>
                                                            <p class="text-muted mb-0 fs-13">August 15, 2025</p>

                                                        </div>
                                                        <button class="btn btn-light btn-sm border">Edit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                       <li>
    <div class="d-flex mb-2 pb-1">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input">
        </div>
        <div class="flex-fill w-100">
            <div class="d-flex align-items-start justify-content-between gap-1">
                <div>
                    <h6 class="d-block fw-medium mb-1 text-dark fs-15">Prepare Exam Timetable</h6>
                    <p class="text-muted mb-0 fs-13">August 5, 2025</p>
                </div>
                <button class="btn btn-light btn-sm border">Edit</button>
            </div>
        </div>
    </div>
</li>

<li>
    <div class="d-flex mb-2 pb-1">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input" checked="">
        </div>
        <div class="flex-fill w-100">
            <div class="d-flex align-items-start justify-content-between gap-1">
                <div>
                    <h6 class="d-block fw-medium mb-1 text-dark fs-15">Update Student Attendance</h6>
                    <p class="text-muted mb-0 fs-13">July 22, 2025</p>
                </div>
                <button class="btn btn-light btn-sm border">Edit</button>
            </div>
        </div>
    </div>
</li>

<li>
    <div class="d-flex mb-2 pb-1">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input">
        </div>
        <div class="flex-fill w-100">
            <div class="d-flex align-items-start justify-content-between gap-1">
                <div>
                    <h6 class="d-block fw-medium mb-1 text-dark fs-15">Review Hifz Progress Reports</h6>
                    <p class="text-muted mb-0 fs-13">July 25, 2025</p>
                </div>
                <button class="btn btn-light btn-sm border">Edit</button>
            </div>
        </div>
    </div>
</li>

<li>
    <div class="d-flex mb-2 pb-1">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input">
        </div>
        <div class="flex-fill w-100">
            <div class="d-flex align-items-start justify-content-between gap-1">
                <div>
                    <h6 class="d-block fw-medium mb-1 text-dark fs-15">Assign Quranic Subjects</h6>
                    <p class="text-muted mb-0 fs-13">August 1, 2025</p>
                </div>
                <button class="btn btn-light btn-sm border">Edit</button>
            </div>
        </div>
    </div>
</li>

<li>
    <div class="d-flex mb-2 pb-1">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input" checked="">
        </div>
        <div class="flex-fill w-100">
            <div class="d-flex align-items-start justify-content-between gap-1">
                <div>
                    <h6 class="d-block fw-medium mb-1 text-dark fs-15">Upload Exam Results</h6>
                    <p class="text-muted mb-0 fs-13">July 20, 2025</p>
                </div>
                <button class="btn btn-light btn-sm border">Edit</button>
            </div>
        </div>
    </div>
</li>

                                        
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Project Statistics -->

                    <!-- Start School and Qur'an System Overview -->
<div class="row">

    <!-- School Categories & Statistics -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0">School Categories</h5>
                </div>
            </div>

            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col align-items-center">
                        <div id="project-categories" class="apex-charts"></div>
                    </div>

                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center p-1">
                            <div>
                                <i class="mdi mdi-circle fs-12 align-middle me-1 text-success"></i>
                                <span class="align-middle fw-semibold">Qur’an Classes</span>
                            </div>
                            <span class="fw-medium text-muted float-end">
                                <i class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>
                                18.5%
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-1">
                            <div>
                                <i class="mdi mdi-circle fs-12 align-middle me-1" style="color: #522c8f;"></i>
                                <span class="align-middle fw-semibold">Primary School</span>
                            </div>
                            <span class="fw-medium text-muted float-end">
                                <i class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>
                                21.3%
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-1">
                            <div>
                                <i class="mdi mdi-circle fs-12 align-middle me-1 text-warning"></i>
                                <span class="align-middle fw-semibold">Secondary School</span>
                            </div>
                            <span class="fw-medium text-muted float-end">
                                <i class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>
                                16.9%
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-1">
                            <div>
                                <i class="mdi mdi-circle fs-12 align-middle me-1" style="color: #01D4FF;"></i>
                                <span class="align-middle fw-semibold">Evening Classes</span>
                            </div>
                            <span class="fw-medium text-muted float-end">
                                <i class="mdi mdi-arrow-up text-success align-middle fs-14 me-1"></i>
                                10.4%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-12 border border-dashed border-1 rounded-2 mt-2">
                    <div class="col">
                        <div class="p-2 border-end border-inline-end-dashed">
                            <p class="mb-1 text-muted text-start">Students Enrolled</p>
                            <div class="d-flex align-items-center mt-2 justify-content-between me-2">
                                <h3 class="mb-0 fs-22 text-dark me-3">1,150</h3>
                                <span class="text-primary fs-14"><i class="mdi mdi-trending-up fs-14"></i> 7.2%</span>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-2 ps-0">
                            <p class="mb-1 text-muted text-start">Active Teachers</p>
                            <div class="d-flex align-items-center mt-2 justify-content-between">
                                <h3 class="mb-0 fs-22 text-dark me-3">42</h3>
                                <span class="text-primary fs-14"><i class="mdi mdi-trending-up fs-14"></i> 5.1%</span>
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


        <!-- Start Projects Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">Projects Summary</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Project</th>
                                        <th>Tasks</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Team</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">1</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14">Update the API</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">101</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 25%">
                                                </div>
                                            </div>
                                            <div class="ms-2">25%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">In
                                            Progress</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">14 November 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">2</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14">Release v1.2-Beta</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">124</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 85%">
                                                </div>
                                            </div>
                                            <div class="ms-2">85%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">In
                                            Progress</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">16 November 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">3</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14"> Landing Design </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">74</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="47" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 47%">
                                                </div>
                                            </div>
                                            <div class="ms-2">47%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">In
                                            Progress</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">18 November 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">4</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14"> Designing New Template</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">08</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 0%">
                                                </div>
                                            </div>
                                            <div class="ms-2">0%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger">Pending</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">20 November 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">5</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14">Plan design offsite</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">52</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="ms-2">100%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Completed</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">25 November 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-dark">6</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium fs-14">Home Page</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">45</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-sm w-100 mt-0" role="progressbar"
                                                aria-valuenow="49" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar  bg-primary" style="width: 49%">
                                                </div>
                                            </div>
                                            <div class="ms-2">49%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">In
                                            Progress</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted">11 December 2024</p>
                                    </td>
                                    <td class="">
                                        <div class="avatar-group avatar-list-stack">
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-12.jpg"
                                                    alt="Dianna Smiley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-2.jpg" alt="Ab Hadley">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-3.jpg" alt="Adolfo Hess">
                                            </a>
                                            <a href="#">
                                                <img class="avatar-img avatar avatar-xs rounded-circle img-fluid"
                                                    src="../assets/images/users/user-4.jpg"
                                                    alt="Daniela Dewitt">
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <a aria-label="anchor"
                                            class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>
                                        <a aria-label="anchor" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

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

        </div> <!-- container-fluid -->
    </div> <!-- content -->

            

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->