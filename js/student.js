$(document).ready(function () {
  let table;

 function initializeTable() {
  table = $('#studentTable').DataTable({
    responsive: true,
    destroy: true,
    columns: [
      { title: "#" },
      { title: "Student ID" },
      { title: "Full Name" },
      { title: "Class" },
      { title: "Parent" },
      { title: "Actions" }
    ]
  });

  // Filter by class
  $('#classFilter').on('change', function () {
    const className = $(this).val();
    if (className) {
      table.column(3).search('^' + className + '$', true, false).draw();
    } else {
      table.column(3).search('').draw();
    }
  });
}


  function fetchStudents() {
  const yearId = getAcademicYearIdFromURL(); // ✅ get from URL instead of a dropdown // get from dropdown
  const url = yearId 
    ? `../api/student_api.php?action=fetch&academic_year_id=${yearId}`
    : `../api/student_api.php?action=fetch`;

  $.getJSON(url, function (data) {
    table.clear();

    if (!data || data.length === 0) {
      const rowNode = table.row.add(['', '', '', '', '', '']).draw().node();
      $(rowNode).html(`<td colspan="6" class="text-center text-muted">No students found</td>`);
      return;
    }

    data.forEach((row, i) => {
      table.row.add([
        i + 1,
        row.student_id,
        row.full_name,
        row.class_name,
        row.parent_name,
        `
        <button class="btn btn-info btn-sm view-btn" data-id="${row.id}"><i class="fas fa-eye"></i></button>
        <button class="btn btn-warning btn-sm edit-btns" data-id="${row.id}"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger btn-sm delete-btns" data-id="${row.id}"><i class="fas fa-trash"></i></button>
        `
      ]);
    });

    table.draw();
  });
}


  function generateStudentId() {
    const academicYearId = $('#academic_year_id').val();
    if (!academicYearId) return;

    $.getJSON(`../api/student_api.php?action=generate_id&academic_year_id=${academicYearId}`, function (res) {
      if (res.student_id) {
        $('#student_id').val(res.student_id);
      } else {
        alert('Failed to generate student ID');
      }
    });
  }

  // Reset modal for add mode
  function resetModalForAdd() {
    $('#studentForm')[0].reset();
    $('#student_db_id').val('');
    $('#student_id').prop('readonly', true);
    generateStudentId();

    $('#addStudentModal .modal-title').text('Register Student');
    $('#addStudentModal button[type="submit"]').text('Add Student');
  }

  // When Add New button is clicked
  $('#btnAddStudent').on('click', function () {
    resetModalForAdd();
    $('#addStudentModal').modal('show');
  });

  // Submit form
  $('#studentForm').submit(function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const isEdit = $('#student_db_id').val() !== '';

    if (isEdit) {
      formData.append('id', $('#student_db_id').val());
    }

    $.ajax({
      url: `../api/student_api.php?action=${isEdit ? 'update' : 'create'}`,
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          $('#addStudentModal').modal('hide');
          fetchStudents();
          Swal.fire({
            icon: 'success',
            title: isEdit ? 'Student Updated Successfully!' : 'Student Added Successfully!',
            showConfirmButton: false,
            timer: 2000
          });
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      },
      error: function () {
        Swal.fire('Error', 'Could not connect to server.', 'error');
      }
    });
  });

  // View student details
$(document).on('click', '.view-btn', function () {
  const id = $(this).data('id');
  $.getJSON(`../api/student_api.php?action=get&id=${id}`, function (data) {
    let tableRows = '';

    // Map for department_type display
    const deptMap = {
      quranic: 'Quranic',
      school: 'School',
      both: 'Quranic & School'
    };

    for (const key in data) {
      if (key === 'student_image') continue;

      const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      let value = data[key] || '-';

      // Replace department_type with friendly name
      if (key === 'department_type' && value in deptMap) {
        value = deptMap[value];
      }

      tableRows += `<tr><th class="text-start">${label}:</th><td>${value}</td></tr>`;
    }

    const imageHTML = data.student_image
      ? `<div class="text-center mb-3">
          <img src="${data.student_image}" class="rounded shadow-sm" style="max-height: 150px;">
        </div>`
      : '';

    $('#studentInfoTable').html(`
      ${imageHTML}
      <table class="table table-bordered">
        <tbody>${tableRows}</tbody>
      </table>
    `);

    $('#viewStudentModal').modal('show');
  });
});


  $(document).on('click', '.delete-btns', function () {
    const id = $(this).data('id'); // ✅ correct

    Swal.fire({
      title: 'Delete Student?',
      text: "This action cannot be undone.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('../api/student_api.php?action=delete', { id }, function (res) {
          if (res.status === 'deleted') {
            Swal.fire('Deleted!', 'Student has been deleted.', 'success');
            fetchStudents();
          } else {
            Swal.fire('Error', res.message || 'Failed to delete student.', 'error');
          }
        }, 'json');
      }
    });
  });

  // Edit student
  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');   

    $.getJSON(`../api/student_api.php?action=get&id=${id}`, function (data) {
      $('#student_db_id').val(data.id);
      $('#student_id2').val(data.student_id2);
      $('#full_name').val(data.full_name);
      $('#gender').val(data.gender);
      $('#dob').val(data.date_of_birth);
      $('#place_of_birth').val(data.place_of_birth);
      // $('#address').val(data.address);
      $('#class_id').val(data.class_id);
      $('#academic_year_id').val(data.academic_year_id);
      $('#parent_id').val(data.parent_id);
      $('#status').val(data.status);
      $('#notes').val(data.notes);
      $('#department_type').val(data.department_type);  
      $('#student_id').prop('readonly', true);
      $('#addStudentModal .modal-title').text('Edit Student');
      $('#addStudentModal button[type="submit"]').text('Update Student');

      $('#addStudentModal').modal('show');
    });
  });

    
     function fetchDashboardCounts() {
  $.getJSON('../api/student_api.php?action=dashboard_counts', function (data) {
    $('#studentCount').text(data.students);
    $('#classCount').text(data.classes);
  });
}

// Call this on page load
fetchDashboardCounts();

   function getAcademicYearIdFromURL() {
  const params = new URLSearchParams(window.location.search);
  return params.get('academic_year_id') || '';
}

    
  // Initialize everything
  initializeTable();
  fetchStudents();

});
