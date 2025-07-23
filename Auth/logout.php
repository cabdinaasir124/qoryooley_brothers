<?php
session_start();
session_destroy();
setcookie("remember_user", "", time() - 3600, "/");
// Redirect to login page
header("Location: http://localhost/qoryooley-brothers/Auth/login.php");
exit;
