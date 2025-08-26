<?php
header("Content-Type: application/json");
require_once '../config/conn.php';

function send_response($success, $message, $data = null) {
  echo json_encode(["success"=>$success, "message"=>$message, "data"=>$data]);
  exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
  case 'get_permissions':
    $res = $conn->query("SELECT * FROM permissions");
    $perms = $res->fetch_all(MYSQLI_ASSOC);
    send_response(true, "Permissions loaded", $perms);
    break;

  case 'get_user_permissions':
    $user_id = intval($_GET['user_id'] ?? 0);
    $res = $conn->query("SELECT permission_id FROM user_permissions WHERE user_id=$user_id");
    $user_perms = array_column($res->fetch_all(MYSQLI_ASSOC), 'permission_id');
    send_response(true, "User permissions loaded", $user_perms);
    break;

  case 'assign_permissions':
    $user_id = intval($_POST['user_id'] ?? 0);
    $perms   = $_POST['permissions'] ?? [];

    if ($user_id <= 0) send_response(false, "Invalid User ID");

    // delete old permissions
    $conn->query("DELETE FROM user_permissions WHERE user_id=$user_id");

    // insert new
    $stmt = $conn->prepare("INSERT INTO user_permissions (user_id, permission_id) VALUES (?,?)");
    foreach ($perms as $pid) {
      $stmt->bind_param("ii", $user_id, $pid);
      $stmt->execute();
    }

    send_response(true, "Permissions updated");
    break;

  default:
    send_response(false, "Invalid action");
}
