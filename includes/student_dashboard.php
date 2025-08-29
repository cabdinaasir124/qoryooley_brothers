
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Teacher Dashboard</h4>
                </div>
            </div>

            <!-- start row -->
            <div class="row">
                <div class="col-md-12 col-xl-4">
                    <div class="row g-3">

                        <!-- Upgrade Plan Card -->
                        <div class="col-md-12 col-xl-12">
                            <div class="card bg-primary-subtle overflow-hidden mb-0">
                                <div class="card-body">
                                    <div class="d-flex align-content-center justify-content-between">
                                        <div class="d-flex align-items-start flex-column h-100">
                                            <h3 class="text-dark fw-semibold fs-20 lh-base mx-auto mb-3">Manage your classes efficiently
                                            <br>with full control</h3>
                                            <a href="../Admin/class_list.php" class="btn btn-sm btn-danger">View All Classes</a>
                                        </div>
                                        <div class="">
                                            <img src="assets/images/widget/teacher.png" alt="" class="mb-n3 float-end"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Students Count -->
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-0">
                                <div class="card-body">

                                    <div class="d-flex mb-2">
                                        <div class="rounded-2 bg-white p-1 shadow-sm border">
                                            <i class="bi bi-people-fill" style="font-size:20px; color:#c26316"></i>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="fs-16 mb-1">Total Students</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-dark" id="Stotal"></div>
                                        <div class="me-auto">
                                            <!-- <span class="text-primary d-inline-flex align-items-center">
                                                8%
                                                <i data-feather="trending-up" class="ms-1" style="height: 20px; width: 20px;"></i>
                                            </span> -->
                                        </div>
                                    </div>

                                    <div id="students-chart" class="apex-charts"></div>

                                </div>
                            </div>
                        </div>

                        <!-- Attendance -->
                        <div class="col-md-6 col-xl-6">
                            <div class="card mb-0">
                                <div class="card-body">

                                    <div class="d-flex mb-2">
                                        <div class="rounded-2 bg-white p-1 shadow-sm border">
                                            <i class="bi bi-journal-check" style="font-size:20px; color:#E7366B"></i>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="fs-16 mb-1">Attendance</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-dark" id="atendenceTotal"></div>
                                        <div class="me-auto">
                                            <!-- <span class="text-success d-inline-flex align-items-center">
                                                5%
                                                <i data-feather="trending-up" class="ms-1" style="height: 20px; width: 20px;"></i>
                                            </span> -->
                                        </div>
                                    </div>

                                    <div id="attendance-chart" class="apex-charts"></div>

                                </div>
                            </div>
                        </div>

                        <!-- Assignments -->
                        <div class="col-md-6 col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <div class="d-flex mb-2">
                                        <div class="rounded-2 bg-white p-1 shadow-sm border">
                                            <i class="bi bi-pencil-square" style="font-size:20px; color:#287F71"></i>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="fs-16 mb-1">Teachers</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-dark" id="All_teachers"></div>
                                        <div class="me-auto">
                                            <!-- <span class="text-primary d-inline-flex align-items-center">
                                                12%
                                                <i data-feather="trending-up" class="ms-1" style="height: 20px; width: 20px;"></i>
                                            </span> -->
                                        </div>
                                    </div>

                                    <div id="assignments-chart" class="apex-charts"></div>

                                </div>
                            </div>
                        </div>

                        <!-- Exams -->
                        <div class="col-md-6 col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <div class="d-flex mb-2">
                                        <div class="rounded-2 bg-white p-1 shadow-sm border">
                                            <i class="bi bi-bar-chart-line" style="font-size:20px; color:#108dff"></i>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="fs-16 mb-1">Exams Conducted</div>
                                    </div>

                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-dark" id="examTotal"></div>
                                        <div class="me-auto">
                                            <!-- <span class="text-primary d-inline-flex align-items-center">
                                                4%
                                                <i data-feather="trending-up" class="ms-1" style="height: 20px; width: 20px;"></i>
                                            </span> -->
                                        </div>
                                    </div>

                                    <div id="exams-chart" class="apex-charts"></div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- end left col -->

                <!-- Right Column: Earnings Reports → Teacher Stats -->
                <div class="col-md-12 col-xl-8">

                    <div class="bg-light rounded p-3 mb-3 border">
                        <div class="row gap-2 gap-sm-0">
                            <div class="col-12 col-sm-4">
                                <div class="earnings-section">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="bg-success-subtle rounded-2 p-1 me-2 border border-dashed border-success">
                                            <i class="bi bi-person-badge" style="font-size:20px; color:#287F71"></i>
                                        </div>
                                        <h6 class="mb-0 fw-normal fs-16">Classes</h6>
                                    </div>
                                    <h4 class="my-2 text-dark" id="Allclasses"></h4>
                                    <div class="progress w-75" style="height:6px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="earnings-profit border-start border-dashed border-primary-subtle mt-md-0 mt-2">
                                    <div class="ms-md-3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="bg-primary-subtle rounded-2 p-1 me-2 border border-dashed border-primary">
                                                <i class="bi bi-chat-left-text" style="font-size:20px; color:#108dff"></i>
                                            </div>
                                            <h6 class="mb-0 fw-normal fs-16">Assignments</h6>
                                        </div>
                                        <h4 class="my-2 text-dark"></h4>
                                        <div class="progress w-75" style="height:6px">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <div class="col-12 col-sm-4">
                        <div class="earnings-expense border-start border-dashed border-primary-subtle mt-md-0 mt-2">
                            <div class="ms-md-3">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="bg-secondary-subtle rounded-2 p-1 me-2 border border-dashed border-secondary">
                                        <i class="bi bi-calendar3" style="font-size:20px; color:#963b68"></i>
                                    </div>
                                   <h6 class="mb-0 fw-normal fs-16">Published Exams</h6>
                                <h4 class="my-2 text-dark" id="publishedExamsCount"></h4>
                                <div class="progress w-75" style="height:6px">
                                    <div id="publishedExamsProgress" class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                                </div>
                                </div>
                            <h4 class="my-2 text-dark">
                                <?php
                                $upcoming_exams = 0;
                                 $progress = 0;
                                 echo $upcoming_exams; ?>
                                </h4>
                                <div class="progress w-75" style="height:6px">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Teacher Reports Chart -->
               
                </div>
            </div> <!-- end row -->

             <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0">Teacher Activity Reports</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="teacher-activity" class="apex-charts"></div>
                        </div>
                    </div> 
        </div>
            <!-- container-fluid -->
    </div> <!-- content -->

</div>
    </div>
</div>