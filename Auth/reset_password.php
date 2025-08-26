<?php
require_once '../config/conn.php';
session_start();

$msg = '';
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);

    if ($password !== $confirm) {
        $msg = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $msg = "Password must be at least 6 characters.";
    } else {
        // Check if token is valid
        $sql = "SELECT * FROM password_resets WHERE token=? AND expires_at > NOW() LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            $reset = $res->fetch_assoc();
            $email = $reset['email'];

            // Hash password and update
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $conn->query("UPDATE users SET password='$hashed' WHERE email='$email'");

            // Delete reset token
            $conn->query("DELETE FROM password_resets WHERE email='$email'");

            $_SESSION['login_error'] = "Password reset successful. Please log in.";
            header("Location: login.php");
            exit;
        } else {
            $msg = "Invalid or expired token.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Reset Password | Qoryooley Brothers and Sisters School</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logo.jpg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    .brand-logo { height: 100px; margin-bottom: 20px; }
    .login-form { max-width: 400px; width: 100%; padding: 20px; }
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
      z-index: 1;
      overflow: hidden;
    }
    .login-right::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 0;
    }
    .login-right * { position: relative; z-index: 2; }
    @media (max-width: 767.98px) { .login-right { display: none; } }
  </style>
</head>

<body>
  <div class="container-fluid min-vh-100">
    <div class="row h-100">
      
      <!-- Left: Reset Password Form -->
      <div class="col-lg-6 login-left">
        <div class="login-form">
          <div class="text-center mb-4">
            <img src="../assets/images/logo.jpg" alt="School Logo" class="brand-logo" />
          </div>
          <h3 class="mb-4 fw-bold text-primary">Reset Password</h3>
          <p class="mb-4 text-muted">Enter your new password below</p>

          <?php if (!empty($msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= htmlspecialchars($msg) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter new password" required />
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-enter new password" required />
            </div>
            <button type="submit" class="btn btn-success w-100">Update Password</button>
          </form>
          <p>go back to <a href="login.php">login</a
          </p>
          </div>
      </div>

      <!-- Right: Background / Quote -->
      <div class="col-lg-6 login-right">
        <h2 class="fw-bold mb-3">Qoryooley School</h2>
        <p class="testimonial">"Changing your password is the first step to a more secure account."</p>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
