// 📁 File: assets/js/teacher.js

// 🔹 Generate a unique Teacher Code (e.g. T-4521)
function generateTeacherCode() {
  const random = Math.floor(1000 + Math.random() * 9000);
  document.getElementById("teacherCode").value = `T-${random}`;
}

// 🔹 Fetch all classes and populate dropdown
function fetchClasses() {
  fetch('../api/teacher_api.php?action=get_classes')
    .then(res => res.json())
    .then(data => {
      const classDropdown = document.getElementById("classDropdown");
      classDropdown.innerHTML = '<option value="">-- Select Class --</option>';

      data.data.forEach(cls => {
        classDropdown.innerHTML += `<option value="${cls.id}">${cls.class_name}</option>`;
      });
    })
    .catch(() => {
      console.error("Failed to load classes");
    });
}


// 🔹 Fetch and display all teachers in the table
function fetchTeachers() {
  fetch('../api/teacher_api.php?action=get_teachers')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("teacherTableBody");
      tbody.innerHTML = "";

      if (data.status === 'success') {
        data.data.forEach((t, i) => {
          tbody.innerHTML += `
            <tr>
              <td>${i + 1}</td>
              <td>${t.teacher_code}</td>
              <td>${t.full_name}</td>
              <td>${t.email}</td>
              <td>${t.phone}</td>
              <td>${t.qualification}</td>
              <td class="text-center">
              <button  data-bs-toggle="modal" data-bs-target="#viewModal" class='btn btn-sm btn-primary viewBtn' data-id="${t.id}">View</button>
              <button data-bs-toggle="modal" data-bs-target="#editTeacherModal" class='btn btn-sm btn-warning edit-teacher-btn' data-id="${t.id}">Edit</button>
                <button class='btn btn-sm btn-danger delete-teacher-btn' data-id="${t.id}">Delete</button>
              </td>
            </tr>`;
        });

        // Re-initialize DataTable
        if ($.fn.DataTable.isDataTable('#teacherTable')) {
          $('#teacherTable').DataTable().destroy();
        }
        $('#teacherTable').DataTable();

      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to load teachers.'
        });
      }
    })
    .catch(() => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Unable to fetch teacher data.'
      });
    });
}

// 🔹 Handle new teacher form submission
// 🔹 Handle new teacher form submission with loader and instant table refresh
function handleTeacherFormSubmit() {
  const form = document.getElementById("addTeacherForm");
  const submitBtn = form.querySelector("button[type='submit']");
  const originalBtnContent = submitBtn.innerHTML;

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Replace button content with loader
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<img src="../assets/images/loading.png" style="height:20px;margin-right:8px;"> Saving...`;

    const formData = new FormData(form);

    fetch('../api/teacher_api.php?action=save_teacher', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: data.message || 'Teacher saved successfully.',
            timer: 2000,
            showConfirmButton: false
          });
          

          form.reset();
          generateTeacherCode();
          fetchTeachers(); // ✅ Refresh table

          // Close Bootstrap modal
          const closeBtn = document.querySelector("#addTeacherModal .btn-close");
          if (closeBtn) closeBtn.click();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Failed!',
            text: data.message || 'Could not save teacher.'
          });
        }
      })
      .catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Server Error',
          text: 'Something went wrong while saving.'
        });
      })
      .finally(() => {
        // Restore button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnContent;
      });
  });
}

function handleTeacherClick() {
  document.getElementById("teacherTableBody").addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-teacher-btn")) {
      const teacherId = e.target.getAttribute("data-id");

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`../api/teacher_api.php?action=delete_teacher&id=${teacherId}`, {
            method: 'GET'
          })
            .then(res => res.json())
            .then(data => {
              if (data.status === "success") {
                Swal.fire("Deleted!", data.message || "Teacher has been deleted.", "success");
                fetchTeachers(); // ✅ Refresh table
              } else {
                Swal.fire("Error!", data.message || "Could not delete teacher.", "error");
              }
            })
            .catch((error) => {
              console.error(error); // ✅ For debugging
              Swal.fire("Error!", "Something went wrong with the server.", "error");
            });
        }
      });
    }
  });
}
function  handleTeacherView(){
  $(document).on('click', '.viewBtn', function () {
    var teacherId = $(this).data('id');

    $.ajax({
        url: '../api/teacher_api.php',
        type: 'GET',
        data: { action: 'get_teacher', id: teacherId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var teacher = response.data;

                // Show modal or fill fields
                $('#viewModal .modal-body').html(`
                    <p><strong>ID:</strong> ${teacher.id}</p>
                    <p><strong>Full Name:</strong> ${teacher.full_name}</p>
                    <p><strong>Email:</strong> ${teacher.email}</p>
                    <p><strong>Phone:</strong> ${teacher.phone}</p>
                    <p><strong>Qualification:</strong> ${teacher.qualification}</p>
                    <p><strong>Salary:</strong> ${teacher.salary}</p>
                    <p><strong>Class:</strong> ${teacher.class_name}</p>
                `);
                $('#viewModal').modal('show');
            } else {
                alert('Failed to fetch teacher info.');
            }
        }
    });
});

}


function handleTeacherEdit() {
  $(document).on("click", ".edit-teacher-btn", function () {
    var teacherID = $(this).data("id");

    $.ajax({
      url: "../api/teacher_api.php",
      type: "GET",
      data: { action: "edit_teacher", id: teacherID },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          var t = response.data;

          $('#editTeacherModalContent').html(`
            <form id="updateTeacherForm">
              <div class="modal-header">
                <h5 class="modal-title">Update Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body row g-3">
                <input type="hidden" name="id" value="${t.id}">
                <div class="col-md-6">
                  <label class="form-label">Teacher Code</label>
                  <input type="text" name="teacher_code" class="form-control" value="${t.teacher_code}" readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="full_name" class="form-control" value="${t.full_name}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" value="${t.email}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control" value="${t.phone}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Assign Class</label>
                  <select name="class_id" class="form-select" id="editClassDropdown" required>
                    <option value="">-- Select Class --</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Qualification</label>
                  <input type="text" name="qualification" class="form-control" value="${t.qualification}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Salary (USD)</label>
                  <input type="number" name="salary" class="form-control" step="0.01" min="0" value="${t.salary}" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          `);

          // Show modal
          $('#editTeacherModal').modal('show');

          // Populate class dropdown
          fetch('../api/teacher_api.php?action=get_classes')
            .then(res => res.json())
            .then(data => {
              const classDropdown = document.getElementById("editClassDropdown");
              classDropdown.innerHTML = '<option value="">-- Select Class --</option>';
              data.data.forEach(cls => {
                const selected = cls.id == t.class_id ? 'selected' : '';
                classDropdown.innerHTML += `<option value="${cls.id}" ${selected}>${cls.class_name}</option>`;
              });
            });

        } else {
          alert("Failed to fetch teacher info.");
        }
      },
    });
  });

  // Submit update
  $(document).on("submit", "#updateTeacherForm", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../api/teacher_api.php?action=update_teacher', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
          });

          $('#editTeacherModal').modal('hide');
          fetchTeachers(); // Refresh table
        } else {
          Swal.fire('Error!', data.message, 'error');
        }
      })
      .catch(() => {
        Swal.fire('Error!', 'Something went wrong.', 'error');
      });
  });
}




// 🔹 Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  generateTeacherCode();
  fetchTeachers();
  fetchClasses();
  handleTeacherFormSubmit();
   handleTeacherClick(); // 👈 Waa in la wacaa!
    handleTeacherView(); // Waa in laga waco halkan
    handleTeacherEdit();
});
