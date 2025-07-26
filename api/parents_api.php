<?php
// parent_api.php
include '../config/conn.php'; // Your DB connection

$action = $_GET['action'] ?? '';

if ($action == 'fetch') {
    $academic_year_id = $_GET['academic_year_id'] ?? 0;
    $academic_year_id = intval($academic_year_id);

    if ($academic_year_id > 0) {
        $stmt = $conn->prepare("SELECT * FROM parents WHERE academic_year_id = ?");
        $stmt->bind_param("i", $academic_year_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $parents = [];

        while ($row = $result->fetch_assoc()) {
            $parents[] = $row;
        }

        echo json_encode($parents);
    } else {
        echo json_encode([]); // No year selected
    }
    exit;
}


elseif ($action == 'create' || $action == 'update') {
  $id = $_POST['id'] ?? '';
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'] ?? '';
  $relation = $_POST['relationship_to_student'];

 $academic_year_id = $_POST['academic_year_id'] ?? null;

if ($action == 'create') {
  $stmt = $conn->prepare("INSERT INTO parents (name, phone, relationship_to_student, academic_year_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $phone, $relation, $academic_year_id);

  $stmt->execute();
  echo json_encode(['status' => 'success']);
}
 else {
    $stmt = $conn->prepare("UPDATE parents SET name=?, phone=?, relationship_to_student=?, academic_year_id=? WHERE id=?");
    $stmt->bind_param("sssii", $name, $phone, $relation, $academic_year_id, $id);

    $stmt->execute();
    echo json_encode(['status' => 'updated']);
  }
}

elseif ($action == 'delete') {
  $id = $_POST['id'];
  $conn->query("DELETE FROM parents WHERE id=$id");
  echo json_encode(['status' => 'deleted']);
}

elseif ($action == 'get') {
    $id = $_GET['id'];

    // Get parent details
    $stmt = $conn->query("SELECT * FROM parents WHERE id = $id");
    $parent = $stmt->fetch_assoc();

    // Get children linked to this parent
    $childrenResult = $conn->query("
        SELECT full_name 
        FROM students 
        WHERE parent_id = $id
    ");

    $children = [];
    while ($row = $childrenResult->fetch_assoc()) {
        $children[] = $row['full_name'];
    }

    // Add children to the response
    $parent['children'] = $children;

    echo json_encode($parent);
    exit;
}

?>
