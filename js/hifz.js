$(document).ready(function () {
  let hifzTable;

  loadStudents();
  loadHifz();

 function loadStudents() {
  $.get('../api/hifz_api.php?action=get_students', function(data) {
    let options = '<option value="">Select Student</option>';
    data.forEach(s => {
      options += `<option value="${s.id}">${s.name}</option>`;
    });
    $('#student_id').html(options);

    // Initialize Select2 with nice Bootstrap theme
    $('#student_id').select2({
      placeholder: "🔍 Search or select a student",
      allowClear: true,
      theme: "bootstrap4",
      dropdownParent: $('#hifzModal') // important for modals
    });
  }, 'json');
}



  function loadHifz() {
    $.get('../api/hifz_api.php?action=get_hifz', function(data) {
      if (hifzTable) {
        hifzTable.clear().destroy();
        }
        

      let rows = data.map(h => [
        h.student_name,
        h.juz_completed,
        h.last_surah,
        h.revision_notes || '',
        h.created_at || '',
        `
          <button class="btn btn-sm btn-primary edit-btn-hifz" data-id="${h.id}">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-danger delete-btn-hifz" data-id="${h.id}">
            <i class="bi bi-trash"></i>
          </button>
        `
      ]);

      hifzTable = $('#hifzTable').DataTable({
        data: rows,
        columns: [
          { title: "Student Name" },
          { title: "Juz Completed" },
          { title: "Last Surah" },
          { title: "Revision Notes" },
          { title: "created date" },
          { title: "Actions", orderable: false, searchable: false }
        ]
      });
    }, 'json');
  }

  $('#hifzForm').submit(function(e) {
    e.preventDefault();
    $.post('../api/hifz_api.php?action=add_hifz', $(this).serialize(), function(res) {
      if (res.success) {
        $('#hifzModal').modal('hide');
        $('#hifzForm')[0].reset();
        loadHifz();
      } else {
        alert('Error: ' + res.message);
      }
    }, 'json');
  });

  // Action buttons
  $('#hifzTable').on('click', '.edit-btn', function () {
    let id = $(this).data('id');
    alert('Edit record ID: ' + id);
  });

  $('#hifzTable').on('click', '.delete-btn', function () {
    let id = $(this).data('id');
    if (confirm('Are you sure you want to delete this record?')) {
      $.post('../api/hifz_api.php?action=delete_hifz', { id }, function(res) {
        if (res.success) {
          loadHifz();
        } else {
          alert('Error: ' + res.message);
        }
      }, 'json');
    }
  });
});
