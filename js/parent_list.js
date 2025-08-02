$(document).ready(function () {
  let table;

  // Get academic year ID from URL
  function getAcademicYearId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('academic_year_id');
  }

  // Initialize DataTable — DO NOT define 'columns' if you have <thead> in HTML
  function initializeDataTable() {
    table = $('#parentTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true
    });
  }

  // Fetch and populate parent data
  function fetchParents() {
    const yearId = getAcademicYearId();
    if (!yearId) return;

    $.getJSON(`../api/parents_api.php?action=fetch&academic_year_id=${yearId}`, function (data) {
      table.clear();

      if (!Array.isArray(data) || data.length === 0) {
        table.row.add([
          '', 'No parents found', '', '', '', '', '', ''
        ]);
      } else {
        data.forEach((row, i) => {
          table.row.add([
            i + 1,
            row.name,
            row.phone,
            row.relationship_to_student,
            row.Address,
            row.guarantor,
            `<button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}">
              <i class="fas fa-edit"></i> Edit
            </button>`,
            `<button class="btn btn-danger btn-sm" id='delete-btn' data-id="${row.id}">
              <i class="fas fa-trash"></i> Delete
            </button>`
          ]);
        });
      }

      table.draw();
    });
  }

  // Submit form (Create or Update)
  $('#parentForm').submit(function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const action = $('#parent_id').val() === '' ? 'create' : 'update';

    $.post(`../api/parents_api.php?action=${action}`, formData, function (res) {
      if (res.status === 'success' || res.status === 'updated') {
        $('#parentForm')[0].reset();
        $('#parent_id').val('');
        $('#parentModal').modal('hide');
        fetchParents();

        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: action === 'create' ? 'Parent added successfully!' : 'Parent updated successfully!',
          timer: 2000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: res.message || 'Something went wrong!'
        });
      }
    }, 'json');
  });

  // Edit button
  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');

    $.getJSON(`../api/parents_api.php?action=get&id=${id}`, function (data) {
      $('#parent_id').val(data.id);
      $('#parent_name').val(data.name);
      $('#parent_phone').val(data.phone);
      $('#relationship').val(data.relationship_to_student);
      $('#Address').val(data.Address);
      $('#guarantor').val(data.guarantor);

      const $list = $('#childrenList').empty();
      if (Array.isArray(data.children) && data.children.length > 0) {
        data.children.forEach(child => {
          $list.append(`<li class="list-group-item">${child}</li>`);
        });
      } else {
        $list.append('<li class="list-group-item text-muted">No children linked</li>');
      }

      $('#parentModal').modal('show');
    });
  });

  // Delete button
 $(document).on('click', '#delete-btn', function () {
  const id = $(this).data('id');

  Swal.fire({
    title: 'Are you sure?',
    text: 'This will permanently delete the parent!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
     $.post('../api/parents_api.php?action=delete', { id }, function (res) {
  if (res.status === 'deleted') {
    Swal.fire({
      icon: 'success',
      title: 'Deleted!',
      text: 'Parent has been deleted.',
      timer: 1500,
      showConfirmButton: false
    }).then(() => {
      fetchParents();  // ✅ GOOD
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: res.message || 'Failed to delete parent!'
    });
  }
}, 'json');


    }
  });
});


  // Modal cleanup on close
  $('#parentModal').on('hidden.bs.modal', function () {
    $('#parentForm')[0].reset();
    $('#parent_id').val('');
    $('#childrenList').html('<li class="list-group-item text-muted">No children linked</li>');
  });

  // Change Academic Year filter
  $('#filterAcademicYear').on('change', function () {
    const selectedYearId = $(this).val();
    $('input[name="academic_year_id"]').val(selectedYearId);
    fetchParents();
  });

  // Init on page load
  initializeDataTable();
  fetchParents();
});
