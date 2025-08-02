<?php
// 📁 File: api/teacher_api.php
include '../config/conn.php';
require __DIR__ . '/vendor/autoload.php'; // ✅ COMPOSER autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ✅ GET TEACHERS
if ($action === 'get_teachers') {
    header('Content-Type: application/json');

    $sql = "SELECT t.*, c.class_name 
            FROM teachers t 
            LEFT JOIN classes c ON t.class_id = c.id 
            ORDER BY t.id DESC";

    $res = mysqli_query($conn, $sql);
    $teachers = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $teachers[] = [
            'id' => $row['id'],
            'teacher_code' => $row['teacher_code'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'qualification' => $row['qualification'],
            'salary' => $row['salary'],
            'class_name' => $row['class_name'] ?? 'N/A'
        ];
    }

    echo json_encode(['status' => 'success', 'data' => $teachers]);
    exit;
}

// ✅ GET CLASSES
elseif ($action === 'get_classes') {
    header('Content-Type: application/json');

    $res = mysqli_query($conn, "SELECT id, class_name FROM classes");
    $classes = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $classes[] = [
            'id' => $row['id'],
            'class_name' => $row['class_name']
        ];
    }

    echo json_encode(['status' => 'success', 'data' => $classes]);
    exit;
}

// ✅ SAVE TEACHER
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save_teacher') {
    header('Content-Type: application/json');

    $teacher_code = mysqli_real_escape_string($conn, $_POST['teacher_code']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $salary = floatval($_POST['salary']);
    $class_id = intval($_POST['class_id']);

    $sql = "INSERT INTO teachers (teacher_code, full_name, email, phone, qualification, salary, class_id)
            VALUES ('$teacher_code', '$full_name', '$email', '$phone', '$qualification', $salary, $class_id)";

    if (mysqli_query($conn, $sql)) {
        // ✅ Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'qoryooleybns@gmail.com';
            $mail->Password = 'mayzrmbtdkqeukvp'; // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('qoryooleybns@gmail.com', 'Qoryooley Brothers & Sisters');
            $mail->addAddress($email, $full_name);
            $mail->isHTML(true);
            $mail->Subject = "Welcome to Qoryooley Community, $full_name!";
            $mail->Body = "
                <div style='max-width:600px;margin:auto;border:1px solid #ddd;border-radius:10px;overflow:hidden;font-family:sans-serif'>
                    <div style='background:#f9f9f9;padding:20px;text-align:center'>
                        <img src='../assets/images/loading.png' alt='Logo' style='height:60px'>
                    </div>
                    <div style='padding:20px'>
                        <h2 style='color:#333'>Dear $full_name,</h2>
                        <p>We warmly welcome you to <strong>Qoryooley Brothers & Sisters</strong> as one of our valued teachers.</p>
                        <p>We believe your knowledge and experience will help us grow stronger as a community.</p>
                        <p>If you have any questions, feel free to contact us.</p>
                        <p style='margin-top:30px'>Thanks again and welcome aboard!</p>
                    </div>
                    <div style='background:#d4edda;color:#155724;text-align:center;padding:20px'>
                        <p style='margin:0;font-size:16px;font-weight:bold'>Qoryooley Brothers & Sisters Community</p>
                        <p style='margin:5px 0;font-size:14px'>Mogadishu, Somalia | +252-61-XXXXXXX</p>
                        <p style='font-size:13px'>Email: support@qoryooley.org | Web: www.qoryooley.org</p>
                    </div>
                </div>
            ";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Teacher saved and welcome email sent.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'success', 'message' => 'Teacher saved, but email not sent. Error: ' . $mail->ErrorInfo]);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save teacher.']);
    }
    exit;
}

// ✅ DELETE TEACHER
elseif ($action === 'delete_teacher') {
    header('Content-Type: application/json');

    $id = $_GET['id'] ?? '';

    if (!$id || !is_numeric($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid teacher ID.'
        ]);
        exit;
    }

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Teacher deleted successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete teacher.'
        ]);
    }

    $stmt->close();
    exit;
} elseif ($action === 'get_teacher') {
    header('Content-Type: application/json');
    $id = intval($_GET['id'] ?? 0);

    $sql = "SELECT t.*, c.class_name 
            FROM teachers t 
            LEFT JOIN classes c ON t.class_id = c.id 
            WHERE t.id = $id";

    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Teacher not found']);
    }
    exit;
}elseif($action === 'edit_teacher'){
  header('Content-Type: application/json');

  $id = $_GET['id'] ;

  $sql = "SELECT t.*, c.class_name 
          FROM teachers t 
          LEFT JOIN classes c ON t.class_id = c.id 
          WHERE t.id = $id";

  $res = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($res);

  if ($data) {
    echo json_encode(['status'=>'success','data'=>$data]);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Teacher not found']);
  }

  exit;
}


// update Teacher
// ✅ UPDATE TEACHER
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_teacher') {
    header('Content-Type: application/json');

    $id = intval($_POST['id'] ?? 0);
    $teacher_code = mysqli_real_escape_string($conn, $_POST['teacher_code']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $salary = floatval($_POST['salary']);
    $class_id = intval($_POST['class_id']);

    $sql = "UPDATE teachers SET 
                teacher_code='$teacher_code',
                full_name='$full_name',
                email='$email',
                phone='$phone',
                qualification='$qualification',
                salary=$salary,
                class_id=$class_id
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Teacher updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update teacher.']);
    }
    exit;
}





// ❌ INVALID REQUEST
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
exit;

?>
