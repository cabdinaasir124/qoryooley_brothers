<?php
// teachers-list.php
include '../config/conn.php';

// Fetch all teachers
$sql = "SELECT id, teacher_code, full_name, email, phone, qualification, salary, class_id, created_at 
        FROM teachers 
        ORDER BY full_name ASC";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("No teachers found in the database.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
</head>
<body style="background-color:#f4f6f9;">
<div class="content-page">
  <div class="content">
    <div class="container-fluid">
<div class="container">
    <h2 class="text-center mb-4">Our Teachers</h2>
    <div class="row justify-content-center g-4">
        <?php while ($teacher = $result->fetch_assoc()): ?>
            <?php 
                $avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($teacher['full_name']) . "&background=random&color=fff";
            ?>
            <div class="col-12 col-md-4 col-lg-">
                <div class="card border shadow-sm h-100">
                    <div class="card-body text-center">
                        <img src="<?php echo $avatarUrl; ?>" 
                             class="rounded-circle avatar-xl img-thumbnail mb-3" 
                             alt="Profile Picture" 
                             style="width:120px;height:120px;">

                        <div class="mt-2 mb-3">
                            <span class="badge bg-primary-subtle rounded-2 text-primary mb-2 fw-normal">
                                <?php echo htmlspecialchars($teacher['qualification']); ?>
                            </span>
                            <h5 class="m-0 fw-medium text-dark fs-16">
                                <?php echo htmlspecialchars($teacher['full_name']); ?>
                            </h5>
                            <p class="mt-1 mb-0"><?php echo htmlspecialchars($teacher['email']); ?></p>
                        </div>

                        <ul class="list-group text-start mb-3">
                            <li class="list-group-item"><strong>Teacher Code:</strong> <?php echo htmlspecialchars($teacher['teacher_code']); ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($teacher['phone']); ?></li>
                            <li class="list-group-item"><strong>Salary:</strong> $<?php echo number_format($teacher['salary'], 2); ?></li>
                        </ul>

                        <!-- <a href="teacher-profile.php?id=<?php echo $teacher['id']; ?>" class="btn btn-sm btn-primary">View Profile</a> -->
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</div>
    </div>
  </div>

<style>
    .bg-primary-subtle {
        background-color: rgba(13,110,253,0.1) !important;
    }
    .avatar-xl {
        width: 120px;
        height: 120px;
    }
    
</style>

</body>
</html>
