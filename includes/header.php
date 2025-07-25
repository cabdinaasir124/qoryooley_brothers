<?php
include("../config/conn.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();
include("../Auth/auth.php");

// Time-based greeting
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

// Get user profile
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, profile_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($username, $profile_image);
    $stmt->fetch();

    if (empty($profile_image)) {
        $profile_image = "image.png"; // default profile image
    }
}

// Populate academic_years table if not already
$current_year = date("Y");
for ($i = 0; $i < 5; $i++) {
    $start = $current_year + $i;
    $end = $start + 1;
    $year_name = "$start/$end";

    // Make the first year current
    $is_current = ($i === 0) ? 1 : 0;

    $stmt = $conn->prepare("INSERT IGNORE INTO academic_years (year_name, is_current) VALUES (?, ?)");
    $stmt->bind_param("si", $year_name, $is_current);
    $stmt->execute();
}


// ✅ Only insert class if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class_name'], $_POST['academic_year_id'])) {
    $class_name = $_POST['class_name'];
    $academic_year_id = $_POST['academic_year_id'];

    $sql = "INSERT INTO classes (class_name, academic_year_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $class_name, $academic_year_id);
    $stmt->execute();
}

// ✅ Only run this if `academic_year_id` is passed via GET
$classes = [];
if (isset($_GET['academic_year_id'])) {
    $year_id = $_GET['academic_year_id'];
    $result = mysqli_query($conn, "SELECT * FROM classes WHERE academic_year_id = $year_id");

    while ($row = mysqli_fetch_assoc($result)) {
        $classes[] = $row;
    }
}
?>




<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Dashboard | Hando - Responsive Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- App css -->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <script src="../assets/js/head.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


        <!-- Datatables css -->
        <link href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        


        <style>
            .profile-initial {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: white;
            }

        </style>

    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">


    <!-- Topbar Start -->
    <div class="topbar-custom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li>
                        <button class="button-toggle-menu nav-link">
                            <i data-feather="menu" class="noti-icon"></i>
                        </button>
                    </li>
                    <li class="d-none d-lg-block">
                    <h5 class="mb-0"><?php echo "$greeting, $username"; ?></h5>
                    </li>
                </ul>

                <div class="mt-3">
    <form method="GET" action="">
        <select class="form-select" name="academic_year_id" required onchange="this.form.submit()">
            
            <option disabled selected>-- Select Academic Year --</option>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM academic_years ORDER BY year_name ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                $selected = (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $row['id']) ? "selected" : "";
                echo "<option value='{$row['id']}' $selected>{$row['year_name']}</option>";
            }
            ?>
        </select>
    </form>
</div>



                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li class="d-none d-lg-block">
                        <form class="app-search d-none d-md-block me-auto">
                            <div class="position-relative topbar-search">
                                <input type="text" class="form-control ps-4" placeholder="Search..." />
                                <i class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                            </div>
                        </form>
                    </li>

                    <!-- Button Trigger Customizer Offcanvas -->
                    <li class="d-none d-sm-flex">
                        <button type="button" class="btn nav-link" data-toggle="fullscreen">
                            <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                        </button>
                    </li>

                    <!-- Light/Dark Mode Button Themes -->
                    <li class="d-none d-sm-flex">
                        <button type="button" class="btn nav-link" id="light-dark-mode">
                            <i data-feather="moon" class="align-middle dark-mode"></i>
                            <i data-feather="sun" class="align-middle light-mode"></i>
                        </button>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i data-feather="bell" class="noti-icon"></i>
                            <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end"><a href="" class="text-dark"><small>Clear All</small></a></span>Notification
                                </h5>
                            </div>

                            <div class="noti-scroll" data-simplebar>
                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item notify-item text-muted link-primary active">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Carl Steadham</p>
                                        <small class="text-muted">5 min ago</small>
                                    </div>
                                    <p class="mb-0 user-msg">
                                        <small class="fs-14">Completed <span class="text-reset">Improve workflow in Figma</span></small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="notify-content">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="notify-details">Olivia McGuire</p>
                                            <small class="text-muted">1 min ago</small>
                                        </div>

                                        <div class="d-flex mt-2 align-items-center">
                                            <div class="notify-sub-icon">
                                                <i class="mdi mdi-download-box text-dark"></i>
                                            </div>

                                            <div>
                                                <p class="notify-details mb-0">dark-themes.zip</p>
                                                <small class="text-muted">2.4 MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-3.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="notify-content">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="notify-details">Travis Williams</p>
                                            <small class="text-muted">7 min ago</small>
                                        </div>
                                        <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                            <span class="text-primary">@Patryk</span> Please make sure that you're....
                                        </p>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-8.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Violette Lasky</p>
                                        <small class="text-muted">5 min ago</small>
                                    </div>
                                    <p class="mb-0 user-msg">
                                        <small class="fs-14">Completed <span class="text-reset">Create new components</span></small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-5.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="notify-details">Ralph Edwards</p>
                                        <small class="text-muted">5 min ago</small>
                                    </div>
                                    <p class="mb-0 user-msg">
                                        <small class="fs-14">Completed<span class="text-reset">Improve workflow in React</span></small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                    <div class="notify-icon">
                                        <img src="../assets/images/users/user-6.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <div class="notify-content">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="notify-details">Jocab jones</p>
                                            <small class="text-muted">7 min ago</small>
                                        </div>
                                        <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                            <span class="text-reset">@Patryk</span> Please make sure that you're....
                                        </p>
                                    </div>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">View all
                                <i class="fe-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <!-- User Dropdown -->
                    <!-- User Dropdown -->
<li class="dropdown notification-list topbar-dropdown">
    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <img src="../upload/profile/<?php echo htmlspecialchars($profile_image); ?>" alt="user-image" class="rounded-circle" />
        <span class="pro-user-name ms-1">
            <?php echo htmlspecialchars($username); ?> <i class="mdi mdi-chevron-down"></i>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
        <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome !</h6>
        </div>

        <a href="../Admin/profile.php" class="dropdown-item notify-item">
            <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
            <span>My Account</span>
        </a>

        <a href="auth-lock-screen.php" class="dropdown-item notify-item">
            <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
            <span>Lock Screen</span>
        </a>

        <div class="dropdown-divider"></div>

        <a href="../Auth/logout.php" class="dropdown-item notify-item">
            <i class="mdi mdi-location-exit fs-16 align-middle"></i>
            <span>Logout</span>
        </a>
    </div>
</li>

                </ul>
            </div>
        </div>
    </div>
    <!-- end Topbar -->