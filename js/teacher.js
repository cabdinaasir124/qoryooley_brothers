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
                <button class='btn btn-sm btn-primary'>View</button>
                <button class='btn btn-sm btn-warning'>Edit</button>
                <button class='btn btn-sm btn-danger'>Delete</button>
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


// 🔹 Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  generateTeacherCode();
  fetchTeachers();
  fetchClasses();
  handleTeacherFormSubmit();
});
