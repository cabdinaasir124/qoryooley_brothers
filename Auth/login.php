<?php
session_start();
require_once '../config/conn.php'; // DB connection

// ✅ Redirect logged-in users to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: ../Admin/");
    exit;
}

// Initialize error message
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

// ✅ Login handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $remember = isset($_POST["remember"]);

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email and password are required.";
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT id, username, password, role, status FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (strtolower($user['status']) !== 'active') {
            $_SESSION['login_error'] = "Your account is inactive. Please contact admin.";
        } elseif (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["profile_image"] = $user["profile_image"];
            $_SESSION["role"] = $user["role"];

            if ($remember) {
                setcookie("remember_user", $user["id"], time() + (86400 * 30), "/");
            }

            header("Location: ../Admin/");
            exit;
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "User not found.";
    }

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Login | Qoryooley Brothers and Sisters School</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Login portal for Qoryooley Brothers and Sisters School" />
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />

  <!-- Bootstrap & Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
 <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }

    .brand-logo {
      height: 100px;
      margin-bottom: 20px; /* or adjust to your liking */
    }


    .login-form {
      max-width: 400px;
      width: 100%;
      padding: 20px;
    }

    .testimonial {
      font-size: 1.1rem;
      font-style: italic;
      margin-bottom: 20px;
      max-width: 400px;
    }

    .login-left {
      background: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

 .login-right {
  position: relative;
  background-image: url('../assets/images/hero6.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  flex-direction: column;
  text-align: center;
  z-index: 1; /* Ensures content stays on top */
  overflow: hidden;
}


.login-right::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5); /* Dark semi-transparent overlay */
  z-index: 0; /* Pushes it behind the content */
}

.login-right * {
  position: relative;
  z-index: 2;
}

.social-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 5px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      background: #16a085;
      text-decoration: none;
      transition: background 0.3s;
    }
    .social-btn:hover {
      background: #138d75;
    }
    @media (min-width: 768px) {
      .login-image-container {
        display: block;
      }
    }

    @media (max-width: 767.98px) {
      .login-right {
        display: none; /* Hide the right side on small screens */
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid min-vh-100">
    <div class="row h-100">
      
      <!-- Left: Login Form -->
      <div class="col-lg-6 login-left">
        <div class="login-form">
<div class="text-center mb-4">
  <img src="../assets/images/logo.jpg" alt="School Logo" class="brand-logo" />
</div>
          <h3 class="mb-4 fw-bold text-primary">Welcome Back!</h3>
          <p class="mb-4 text-muted">Sign in to continue to Qoryooley Brothers and Sisters School</p>
       <form action="" method="POST">
        <?php if (!empty($error)): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" autocomplete="email" id="email" placeholder="Enter your email" required />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="text" name="password" class="form-control" autocomplete="current-password" id="password" placeholder="Enter your password" required />
  </div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="remember" name="remember" />
      <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
  </div>
  <button type="submit" class="btn btn-primary w-100">Log In</button>
</form>

          <div class="social-buttons">
        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
      </div>
          <!-- <p class="text-center mt-4">Don't have an account? <a href="auth-register.html" class="text-primary fw-semibold">Sign Up</a></p> -->
        </div>
      </div>

      <!-- Right: Info Panel (Hidden on Mobile) -->
      <div class="col-lg-6 login-right">
        <h2 class="fw-bold mb-3">Qoryooley School</h2>
        <p class="testimonial">"Education is the most powerful weapon which you can use to change the world." - Nelson Mandela</p>

        <div id="testimonialCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <p class="testimonial">"Thanks to Qoryooley School, my children are thriving in education and values."</p>
              <h5>- Parent of Grade 6 Student</h5>
            </div>
            <div class="carousel-item">
              <p class="testimonial">"We aim to shape future leaders through quality learning."</p>
              <h5>- Principal, Qoryooley School</h5>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
