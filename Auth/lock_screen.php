<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'] ?? "User";
$email = $_SESSION['email'] ?? "user@example.com";
$profile_image = $_SESSION['profile_image'] ?? "default.png";
$image_path = "../upload/profile/" . $profile_image;
// ✅ Handle unlock form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../config/conn.php';
    $password = trim($_POST["password"]);

    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $role = $_SESSION['role'];
        switch ($role) {
            case 'admin': header("Location: ../Admin/"); break;
            case 'student': header("Location: ../students/"); break;
            case 'parent': header("Location: ../parents/"); break;
            case 'teacher': header("Location: ../teachers/"); break;
            default: header("Location: ../index.php");
        }
        exit;
    } else {
        $error = "Incorrect password. Try again!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Lock Screen | Qoryooley School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<!-- Begin page -->
<div class="account-page">
    <div class="container-fluid p-0">
        <div class="row align-items-center g-0 px-3 py-3 vh-100">

            <!-- Left Side (Lock Form) -->
            <div class="col-xl-5">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-md-4">

                                    <div class="mb-4 text-center">
                                        <a href="index.php" class="logo logo-light">
                                            <img src="../assets/images/logo.jpg" alt="" height="90">
                                        </a>
                                    </div>

                                    <div class="auth-title-section mb-4 text-center">
                                        <h3 class="text-dark fw-semibold mb-3">Lock Screen</h3>
                                        <p class="text-muted fs-14 mb-0">Welcome back, <?= htmlspecialchars($username) ?>!</p>
                                    </div>

                                   <div class="d-flex justify-content-center mb-3">
                                        <div>
                                            <img src="<?= htmlspecialchars($image_path) ?>" alt="User" class="avatar avatar-lg border border-3 border-primary  rounded-circle">
                                        </div>
                                    </div>
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger py-1"><?= htmlspecialchars($error) ?></div>
                                    <?php endif; ?>

                                    <form method="POST" class="mt-3">
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control" type="password" name="password" id="password" required placeholder="Enter your password">
                                        </div>

                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        
                                        <div class="form-group mb-0">
                                            <button class="btn btn-primary w-100" type="submit">Unlock</button>
                                        </div>
                                    </form>

                                    <div class="text-center text-muted mt-3">
                                        <p class="mb-0">Not <?= htmlspecialchars($username) ?>? 
                                            <a class="text-danger fw-medium" href="../Auth/logout.php">Logout</a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Carousel / Quotes) -->
            <div class="col-xl-7 d-none d-xl-inline-block">
                <div class="account-page-bg rounded-4">
                    <div class="auth-user-review text-center">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <p class="prelead mb-2 text-white">
                                        "Education is the most powerful weapon which you can use to change the world."
                                    </p>
                                    <h4 class="mb-1 text-white">Nelson Mandela</h4>
                                    <p class="mb-0 text-white-50">Leader & Visionary</p>
                                </div>

                                <div class="carousel-item">
                                    <p class="prelead mb-2 text-white">
                                        "Technology empowers students to unlock their future."
                                    </p>
                                    <h4 class="mb-1 text-white">Qoryooley ICT</h4>
                                    <p class="mb-0 text-white-50">Helping Center</p>
                                </div>

                                <div class="carousel-item">
                                    <p class="prelead mb-2 text-white">
                                        "Knowledge shared is knowledge multiplied."
                                    </p>
                                    <h4 class="mb-1 text-white">Anonymous</h4>
                                    <p class="mb-0 text-white-50">Wisdom</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="../assets/libs/jquery/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../assets/libs/node-waves/waves.min.js"></script>
<script src="../assets/libs/feather-icons/feather.min.js"></script>
<script src="../assets/js/app.js"></script>

</body>
</html>
