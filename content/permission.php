<?php
require '../config/conn.php';

// Fetch all users
$users = $conn->query("SELECT id, username FROM users");
if (!$users) die("Users query failed: " . $conn->error);

// Fetch all permissions
$permissions = $conn->query("SELECT id, name FROM permissions");
if (!$permissions) die("Permissions query failed: " . $conn->error);

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $assigned = $_POST['permissions'] ?? [];

    // Clear old permissions
    $conn->query("DELETE FROM user_permissions WHERE user_id = $user_id");

    // Insert new ones
    foreach ($assigned as $perm_id) {
        $conn->query("INSERT INTO user_permissions (user_id, permission_id) VALUES ($user_id, $perm_id)");
    }

    echo "<div class='alert alert-success'>Permissions updated successfully!</div>";
}

// If user selected, fetch assigned permissions
$selected_user = $_GET['user_id'] ?? null;
$assigned_permissions = [];
if ($selected_user) {
    $res = $conn->query("SELECT permission_id FROM user_permissions WHERE user_id = " . intval($selected_user));
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $assigned_permissions[] = $row['permission_id'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Permissions</title>
</head>
<body class="p-4">
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
<div class="container">
    <h3 class="mb-3">Assign Permissions</h3>

    <!-- User selection -->
    <form method="get" class="mb-3">
        <label for="user_id" class="form-label">Select User</label>
        <select name="user_id" id="user_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Select User --</option>
            <?php while($u = $users->fetch_assoc()): ?>
                <option value="<?= $u['id'] ?>" <?= ($selected_user == $u['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['username']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($selected_user): ?>
        <!-- Permission assignment form -->
        <form method="post">
            <input type="hidden" name="user_id" value="<?= $selected_user ?>">

            <div class="card p-3">
                <h5 class="mb-3">Assign Permissions to User</h5>
                <?php while($p = $permissions->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= $p['id'] ?>"
                            <?= in_array($p['id'], $assigned_permissions) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= htmlspecialchars($p['name']) ?></label>
                    </div>
                <?php endwhile; ?>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Permissions</button>
        </form>
    <?php endif; ?>
</div>
    </div>
    </div>
                    </div>
</body>
</html>
