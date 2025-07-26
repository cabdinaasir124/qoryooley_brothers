$(document).ready(function () {
    let table;
    
     function getAcademicYearId() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('academic_year_id');
    }


  // Initialize DataTable (only once)
  function initializeDataTable() {
    table = $('#parentTable').DataTable({
      responsive: true,
      ordering: true,
      searching: true,
      columns: [
        { title: "#" },
        { title: "Name" },
        { title: "Phone" },
        { title: "Relationship" },
        { title: "Edit" },
        { title: "Delete" },
      ]
    });
  }

  // Update hidden input when academic year changes
$('#filterAcademicYear').on('change', function () {
    const selectedYearId = $(this).val();
    $('input[name="academic_year_id"]').val(selectedYearId); // Set the hidden input
    fetchParents(); // Reload data
});


  // Load Data into DataTable
function fetchParents() {
  const yearId = getAcademicYearId();
  if (!yearId) return;

  $.getJSON(`../api/parents_api.php?action=fetch&academic_year_id=${yearId}`, function (data) {
    if (table) table.clear().draw();

    if (!data || data.length === 0) {
      table.row.add([
        '', // Index column
        'No parents found',
        '',
        '',
        '',
        ''
      ]).draw();
      return;
    }

    data.forEach((row, i) => {
      table.row.add([
        i + 1,
        row.name,
        row.phone,
        row.relationship_to_student,
        `<button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}"><i class="fas fa-edit"></i> Edit</button>`,
        `<button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fas fa-trash"></i> Delete</button>`
      ]);
    });

    table.draw();
  });
}


  // Initialize Table first
  initializeDataTable();
  fetchParents();

  // On Academic Year change
  $('#filterAcademicYear').on('change', fetchParents);

  // Submit Form
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
          showConfirmButton: false,
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Something went wrong!',
        });
      }
    }, 'json');
  });

  // Edit Parent
  // Edit Parent
$(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');

    $.getJSON(`../api/parents_api.php?action=get&id=${id}`, function (data) {
        $('#parent_id').val(data.id);
        $('#parent_name').val(data.name);
        $('#parent_phone').val(data.phone);
        $('#relationship').val(data.relationship_to_student);

        // Clear and repopulate children list
        const $list = $('#childrenList');
        $list.empty();

        if (data.children && data.children.length > 0) {
            data.children.forEach(child => {
                $list.append(`<li class="list-group-item">${child}</li>`);
            });
        } else {
            $list.append(`<li class="list-group-item text-muted">No children linked</li>`);
        }

        $('#parentModal').modal('show');
    });
});


  // Delete Parent
  $(document).on('click', '.delete-btn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "This will permanently delete the parent!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('../api/parents_api.php?action=delete', { id }, function (res) {
          if (res.status === 'deleted') {
            fetchParents();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'Parent has been deleted.',
              timer: 2000,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to delete parent!',
            });
          }
        }, 'json');
      }
    });
  });

  $('#parentModal').on('hidden.bs.modal', function () {
  $('#parentForm')[0].reset();
  $('#parent_id').val('');

  // Clear the children list so it doesn't show stale data
  $('#childrenList').html('<li class="list-group-item text-muted">No children linked</li>');
});

  

    
});
