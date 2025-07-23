$(document).ready(function () {
  $(document).on('submit', '#userForm', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('action', 'add_user'); // ✅ match PHP

    $.ajax({
      type: "POST",
      url: "../api/users_api.php",
      data: formData,
      processData: false, // ✅ required for FormData
      contentType: false, // ✅ required for FormData
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success"
          });
          $('#userForm')[0].reset();
          $('#userModal').modal('hide');
        } else {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error"
          });
        }
      },
      error: function () {
        Swal.fire({
          title: "Server Error!",
          text: "Could not connect to server.",
          icon: "error"
        });
      }
    });
  });
});
