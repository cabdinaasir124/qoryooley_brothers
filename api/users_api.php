<?php
header("Content-Type: application/json");
require_once '../config/conn.php';

function send_response($success, $message, $data = null) {
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add_user': // CREATE
        $required = ['username','email','password','role','status'];
        foreach ($required as $f) if (empty($_POST[$f])) send_response(false, "Missing: $f");

        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role     = trim($_POST['role']);
        $status   = trim($_POST['status']);

        $stmt = $conn->prepare("INSERT INTO users (username,email,password,role,status) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $username,$email,$password,$role,$status);
        $stmt->execute() ? send_response(true,"User added") : send_response(false,$stmt->error);
        break;

    case 'get_users': // READ all
        $res = $conn->query("SELECT id, username, email, role, status, created_at FROM users ORDER BY id DESC");
        $users = $res->fetch_all(MYSQLI_ASSOC);
        send_response(true,"Users loaded",$users);
        break;

    case 'get_user': // READ single
        $id = intval($_GET['id'] ?? 0);
        $res = $conn->query("SELECT id, username, email, role, status, created_at FROM users WHERE id=$id");
        $user = $res->fetch_assoc();
        $user ? send_response(true,"User loaded",$user) : send_response(false,"Not found");
        break;

    case 'update_user': // UPDATE
        $required = ['id','username','email','role','status'];
        foreach ($required as $f) if (empty($_POST[$f])) send_response(false, "Missing: $f");

        $id       = intval($_POST['id']);
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $role     = trim($_POST['role']);
        $status   = trim($_POST['status']);

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=?, role=?, status=? WHERE id=?");
            $stmt->bind_param("sssssi",$username,$email,$password,$role,$status,$id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=?, status=? WHERE id=?");
            $stmt->bind_param("ssssi",$username,$email,$role,$status,$id);
        }

        $stmt->execute() ? send_response(true,"User updated") : send_response(false,$stmt->error);
        break;

    case 'delete_user': // DELETE
        $id = intval($_POST['id'] ?? 0);
        if ($id<=0) send_response(false,"Invalid ID");
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute() ? send_response(true,"User deleted") : send_response(false,$stmt->error);
        break;

    default:
        send_response(false,"Invalid action");
}
