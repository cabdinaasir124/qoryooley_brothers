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
    <div class="container-fluid">
<div class="container mt-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">User List</h5>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fas fa-user-plus"></i>&nbsp;Add New User
      </button>
    </div>

    <div class="card-body table-responsive">
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
      </table>
    </div>
  </div>
</div>
</div>
  </div>
</div>
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="addUserForm">
        <div class="modal-header"><h5>Add New User</h5></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
          <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
          <div class="col-md-6"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
          <div class="col-md-3">
            <select name="role" class="form-control" required>
              <option value="Admin">Admin</option>
              <option value="Teacher">Teacher</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="status" class="form-control" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button type="submit" class="btn btn-success">Save</button></div>
      </form>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header"><h5>Edit User</h5></div>
        <div class="modal-body row g-3">
          <input type="hidden" name="id">
          <div class="col-md-6"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
          <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
          <div class="col-md-6"><input type="password" name="password" class="form-control" placeholder="Leave blank to keep"></div>
          <div class="col-md-3">
            <select name="role" class="form-control" required>
              <option value="Admin">Admin</option>
              <option value="Teacher">Teacher</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="status" class="form-control" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button type="submit" class="btn btn-warning">Update</button></div>
      </form>
    </div>
  </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5>User Details</h5></div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><b>ID:</b> <span id="v-id"></span></li>
          <li class="list-group-item"><b>Username:</b> <span id="v-username"></span></li>
          <li class="list-group-item"><b>Email:</b> <span id="v-email"></span></li>
          <li class="list-group-item"><b>Role:</b> <span id="v-role"></span></li>
          <li class="list-group-item"><b>Status:</b> <span id="v-status"></span></li>
          <li class="list-group-item"><b>Created At:</b> <span id="v-created"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>


</body>
</html>
