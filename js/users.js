$(document).ready(function () {
  let userTable = $('#userTable').DataTable({
    ajax: {
      url: "../api/users_api.php",
      type: "GET",
      data: { action: "get_users" },
      dataSrc: "data"
    },
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    columns: [
      { data: "id" },
      { data: "username" },
      { data: "email" },
      { data: "role" },
      { 
        data: "status",
        render: d => d === "active" 
          ? `<span class="badge bg-success">Active</span>` 
          : `<span class="badge bg-danger">Inactive</span>`
      },
      { data: "created_at" },
      { data: "id", render: id => `<button class="btn btn-info btn-sm viewBtn-user" data-id="${id}"><i class="fas fa-eye"></i></button>` },
      { data: "id", render: id => `<button class="btn btn-warning btn-sm editBtn-user" data-id="${id}"><i class="fas fa-edit"></i></button>` },
      { data: "id", render: id => `<button class="btn btn-danger btn-sm deleteBtn-user" data-id="${id}"><i class="fas fa-trash"></i></button>` }
    ]
  });

  // CREATE
  $('#addUserForm').on('submit', function (e) {
    e.preventDefault();
    let fd = new FormData(this);
    fd.append('action', 'add_user');
    $.ajax({
      type: "POST", url: "../api/users_api.php", data: fd,
      processData: false, contentType: false, dataType: "json",
      success: r => {
        Swal.fire(r.success ? "Added" : "Error", r.message, r.success ? "success" : "error");
        if (r.success) { $('#addUserModal').modal('hide'); this.reset(); userTable.ajax.reload(); }
      }
    });
  });

  // VIEW
  $(document).on('click', '.viewBtn-user', function () {
    let id = $(this).data('id');
    $.get("../api/users_api.php", { action: "get_user", id }, r => {
      if (r.success) {
        let u = r.data;
        $('#v-id').text(u.id);
        $('#v-username').text(u.username);
        $('#v-email').text(u.email);
        $('#v-role').text(u.role);
        $('#v-status').text(u.status);
        $('#v-created').text(u.created_at);
        $('#viewUserModal').modal('show');
      } else {
        Swal.fire("Error", r.message, "error");
      }
    }, "json");
  });

  // LOAD for Edit
  $(document).on('click', '.editBtn-user', function () {
    let id = $(this).data('id');
    $.get("../api/users_api.php", { action: "get_user", id }, r => {
      if (r.success) {
        let u = r.data;
        $('#editUserForm [name=id]').val(u.id);
        $('#editUserForm [name=username]').val(u.username);
        $('#editUserForm [name=email]').val(u.email);
        $('#editUserForm [name=role]').val(u.role);
        $('#editUserForm [name=status]').val(u.status);
        $('#editUserModal').modal('show');
      } else {
        Swal.fire("Error", r.message, "error");
      }
    }, "json");
  });

  // UPDATE
  $('#editUserForm').on('submit', function (e) {
    e.preventDefault();
    let fd = new FormData(this);
    fd.append('action', 'update_user');
    $.ajax({
      type: "POST", url: "../api/users_api.php", data: fd,
      processData: false, contentType: false, dataType: "json",
      success: r => {
        Swal.fire(r.success ? "Updated" : "Error", r.message, r.success ? "success" : "error");
        if (r.success) { $('#editUserModal').modal('hide'); userTable.ajax.reload(); }
      }
    });
  });

  // DELETE
  $(document).on('click', '.deleteBtn-user', function () {
    let id = $(this).data('id');
    Swal.fire({
      title: "Are you sure?",
      text: "This will permanently delete the user",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete"
    }).then(res => {
      if (res.isConfirmed) {
        $.post("../api/users_api.php", { action: "delete_user", id }, r => {
          Swal.fire(r.success ? "Deleted" : "Error", r.message, r.success ? "success" : "error");
          if (r.success) userTable.ajax.reload();
        }, "json");
      }
    });
  });
});