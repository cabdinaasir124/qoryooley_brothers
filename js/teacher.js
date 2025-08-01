// Generate unique Teacher Code
function generateTeacherCode() {
  const random = Math.floor(1000 + Math.random() * 9000);
  document.getElementById("teacherCode").value = `T-${random}`;
}

// Fetch and populate class dropdown
function fetchClasses() {
  fetch('../api/teacher_api.php?action=get_classes')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("classDropdown");
      select.innerHTML = '<option value="">-- Select Class --</option>';
      data.data.forEach(cls => {
        select.innerHTML += `<option value="${cls.id}">${cls.class_name}</option>`;
      });
    });
}

// Fetch and display teachers in the table
function fetchTeachers() {
  fetch('../api/teacher_api.php?action=get_teachers')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const tbody = document.getElementById("teacherTableBody");
        tbody.innerHTML = "";
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
                <button class='btn btn-sm btn-primary'>View</button>
                <button class='btn btn-sm btn-warning'>Edit</button>
                <button class='btn btn-sm btn-danger'>Delete</button>
              </td>
            </tr>`;
        });

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
    });
}

// Submit new teacher via AJAX
function handleTeacherFormSubmit() {
  const form = document.getElementById("addTeacherForm");
  form.addEventListener("submit", function (e) {
    e.preventDefault();

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
          fetchTeachers();
          document.querySelector("#addTeacherModal .btn-close").click();
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
      });
  });
}

// Initialize everything on page load
document.addEventListener("DOMContentLoaded", () => {
  generateTeacherCode();
  fetchTeachers();
  fetchClasses();
  handleTeacherFormSubmit();
});
