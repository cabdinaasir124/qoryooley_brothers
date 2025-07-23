<?php
// session_start();

if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/qoryooley-brothers/Auth/login.php");
    exit;
}
?>
