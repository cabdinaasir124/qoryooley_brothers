<?php
require '../config/conn.php'; 
require __DIR__ . '/vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);

    $check = $conn->query("SELECT id FROM users WHERE email='$email' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $user = $check->fetch_assoc();
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $conn->query("INSERT INTO password_resets (user_id, token, expires_at) 
                      VALUES ('{$user['id']}', '$token', '$expires')");

        $resetLink = "http://localhost/qoryooley-brothers/Auth/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'qoryooleybns@gmail.com'; 
            $mail->Password   = 'mayzrmbtdkqeukvp';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('qoryooleybns@gmail.com', 'Qoryooley Brothers System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "
                <p>Hello,</p>
                <p>You requested to reset your password. Click the link below to reset it:</p>
                <p><a href='$resetLink'>$resetLink</a></p>
                <p>This link will expire in 1 hour.</p>
            ";
            $mail->AltBody = "Reset your password using this link: $resetLink";

            $mail->send();
            $msg = "<div class='alert alert-success'>✅ Reset link has been sent to your email!</div>";
        } catch (Exception $e) {
            $msg = "<div class='alert alert-danger'>❌ Message could not be sent. Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email not found!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Forgot Password | Qoryooley Brothers School</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/images/logo.jpg" />
  <!-- Bootstrap & Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }

    .brand-logo {
      height: 100px;
      margin-bottom: 20px;
    }

    .form-box {
      max-width: 400px;
      width: 100%;
      padding: 20px;
    }

    .left-pane {
      background: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .right-pane {
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

    .right-pane::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    .right-pane * {
      position: relative;
      z-index: 2;
    }

    @media (max-width: 767.98px) {
      .right-pane { display: none; }
    }
  </style>
</head>
<body>
  <div class="container-fluid min-vh-100">
    <div class="row h-100">

      <!-- Left: Forgot Password Form -->
      <div class="col-lg-6 left-pane">
        <div class="form-box">
          <div class="text-center mb-4">
            <img src="../assets/images/logo.jpg" alt="School Logo" class="brand-logo" />
          </div>
          <h3 class="mb-3 fw-bold text-primary">Forgot Password?</h3>
          <p class="mb-4 text-muted">Enter your email and we’ll send you a reset link.</p>
          
          <form method="POST">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
          </form>

          <div class="mt-3"><?= $msg ?></div>

          <div class="mt-3">
            <a href="login.php" class="text-decoration-none">← Back to Login</a>
          </div>
        </div>
      </div>

      <!-- Right: Info Panel -->
      <div class="col-lg-6 right-pane">
        <h2 class="fw-bold mb-3">Qoryooley School</h2>
        <p class="testimonial">"Education is the passport to the future, for tomorrow belongs to those who prepare for it today." - Malcolm X</p>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
