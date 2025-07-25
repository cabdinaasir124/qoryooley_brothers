// schedule.js (Cleaned up with SweetAlert2, filter by class, print functionality, and full update)

function openAddScheduleModal() {
  const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
  $('#scheduleForm')[0].reset();
  $('#scheduleForm input[name="id"]').val('');
  $('#schedule_subject_id').html('<option value="">-- Select Subject --</option>');
  modal.show();
}

$(document).ready(function () {
  let table;

  function fetchSubjects(classId, selectedSubject = '') {
    if (classId) {
      $.get('../api/get_subjects_by_class.php', { class_id: classId }, function (response) {
        const $subjectSelect = $('#schedule_subject_id');
        $subjectSelect.empty().append('<option value="">-- Select Subject --</option>');
        response.forEach(subject => {
          const selected = subject.id == selectedSubject ? 'selected' : '';
          $subjectSelect.append(`<option value="${subject.id}" ${selected}>${subject.subject_name}</option>`);
        });
      }, 'json');
    }
  }

  $('#schedule_class_id').on('change', function () {
    fetchSubjects($(this).val());
  });

  function loadTable(classId = '') {
    const academic_year_id = $('#scheduleModal input[name="academic_year_id"]').val();

    if ($.fn.DataTable.isDataTable('#scheduleTable')) {
      $('#scheduleTable').DataTable().destroy();
    }

    table = $('#scheduleTable').DataTable({
      ajax: {
        url: '../api/schedule_api.php?action=fetch',
        data: { academic_year_id, class_id: classId },
        dataSrc: res => res.data
      },
      columns: [
        { data: null, title: "#", render: (data, type, row, meta) => meta.row + 1 },
        { data: 'class_name', title: "Class" },
        { data: 'subject_name', title: "Subject" },
        { data: 'day_of_week', title: "Day" },
        { data: 'start_time', title: "Start Time" },
        { data: 'end_time', title: "End Time" },
        { data: 'teacher_name', title: "Teacher" },
        { data: 'room', title: "Room" },
        { data: 'status', title: "Status" },
        {
          data: null,
          title: "Actions",
          render: (data, type, row) => `
            <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
          `
        }
      ]
    });
  }

  loadTable();

  $('#addScheduleBtn').click(() => openAddScheduleModal());

  $('#filter_class_id').change(function () {
    const classId = $(this).val();
    loadTable(classId);
  });

  $('#scheduleForm').submit(function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.post('../api/schedule_api.php?action=save', formData, function (res) {
      if (res.status === 'success') {
        Swal.fire('Success', res.message, 'success');
        $('#scheduleModal').modal('hide');
        table.ajax.reload();
      } else {
        Swal.fire('Error', res.message, 'error');
      }
    }, 'json').fail(xhr => {
      Swal.fire('Error', xhr.responseText, 'error');
    });
  });

  $('#scheduleTable').on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    $.get('../api/schedule_api.php?action=get', { id }, function (res) {
      if (res.status === 'success') {
        const data = res.data;
        $('#scheduleForm input[name="id"]').val(data.id);
        $('#schedule_class_id').val(data.class_id);
        fetchSubjects(data.class_id, data.subject_id);
        $('#day_of_week').val(data.day_of_week);
        $('#start_time').val(data.start_time);
        $('#end_time').val(data.end_time);
        $('#teacher_name').val(data.teacher_name);
        $('#room').val(data.room);
        $('#schedule_status').val(data.status);
        $('#scheduleModal').modal('show');
      } else {
        Swal.fire('Error', res.message || 'Failed to load data', 'error');
      }
    }, 'json');
  });

  $('#scheduleTable').on('click', '.delete-btn', function () {
    const id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "This will delete the schedule.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('../api/schedule_api.php?action=delete', { id }, function (res) {
          if (res.status === 'success') {
            Swal.fire('Deleted!', res.message, 'success');
            table.ajax.reload();
          } else {
            Swal.fire('Error', res.message, 'error');
          }
        }, 'json');
      }
    });
  });

  $('#printSchedule').click(function () {
  const className = $('#filter_class_id option:selected').text() || 'All Classes';
  const academicYear = $('input[name="academic_year_id"]').val() || 'N/A';

  // Clone the table to manipulate before printing
  const $tableClone = $('#scheduleTable').clone();

  // Remove Actions columns (assuming last two columns are update and delete)
  $tableClone.find('th:last-child, th:nth-last-child(2), td:last-child, td:nth-last-child(2)').remove();

  // Wrap header info with styling
  const schoolInfo = `
    <div style="text-align:center; margin-bottom: 20px;">
      <h1 style="font-family: Arial, sans-serif; color: #003366;">Qoryooley Brothers and Sisters School</h1>
      <h3 style="font-family: Arial, sans-serif; margin: 5px 0;">Class Schedule Report</h3>
      <p style="font-family: Arial, sans-serif; margin: 2px 0;">
        <strong>Academic Year:</strong> ${academicYear}<br>
        <strong>Class:</strong> ${className}<br>
        <strong>Printed on:</strong> ${new Date().toLocaleDateString()}
      </p>
      <hr style="border: 1px solid #003366; margin-top: 10px;">
    </div>
  `;

  const win = window.open('', '', 'width=900,height=700');
  win.document.write('<html><head><title>Print Schedule</title>');

  // Add clean CSS styles for print
  win.document.write(`
    <style>
      body { font-family: Arial, sans-serif; padding: 20px; color: #222; }
      table { width: 100%; border-collapse: collapse; margin-top: 10px; }
      th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
      th { background-color: #003366; color: white; }
      tr:nth-child(even) { background-color: #f2f2f2; }
      h1, h3, p { margin: 0; }
      hr { border: 0; border-top: 2px solid #003366; margin-top: 15px; }
    </style>
  `);

  win.document.write('</head><body>');
  win.document.write(schoolInfo);
  win.document.write($tableClone.prop('outerHTML'));
  win.document.write('</body></html>');

  win.document.close();
  win.print();
});

    
    
    function loadScheduleTable() {
  const academicYearId = $('#academicYearId').val(); // Hidden input or dropdown
  const classId = $('#classFilter').val();

  $.ajax({
    url: '../api/schedule_api.php',
    method: 'GET',
    data: {
      action: 'fetch',
      academic_year_id: academicYearId,
      class_id: classId
    },
    success: function (response) {
      const data = JSON.parse(response);
      scheduleTable.clear().rows.add(data).draw();
    }
  });
}

$('#classFilter').on('change', function () {
  loadScheduleTable();
});

});