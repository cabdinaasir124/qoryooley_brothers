<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="content-page">
  <div class="content">
<div class="container-fluid mt-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User List</h5>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
        <i class="fas fa-user-plus"></i>&nbsp;Add New User
      </button>
    </div>

    <div class="card-body">
      <table id="userTable" class="table table-bordered table-striped w-100">
        <thead>
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example static data row -->
          <!-- Replace this block with dynamic data (PHP/JS) -->
          <tr>
            <td>1</td>
            <td>admin</td>
            <td>admin@example.com</td>
            <td>Admin</td>
            <td><span class="badge bg-success">Active</span></td>
            <td>2025-07-22</td>
            <td><button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button></td>
            <td><button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button></td>
            <td><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal: Add New User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="userForm">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Register New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="col-md-6">
            <label class="form-label">Password</label>
<input type="password" class="form-control" name="password" autocomplete="new-password">
          </div>
          <div class="col-md-6">
            <label class="form-label">Role</label>
            <select class="form-select" name="role">
              <option value="">Select Role</option>
              <option value="Admin">Admin</option>
              <option value="Teacher">Teacher</option>
              <option value="Student">Student</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save User</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
  </div>
</div>



<script>
  $(document).ready(function () {
    $('#userTable').DataTable();
  });
</script>

</body>
</html>
