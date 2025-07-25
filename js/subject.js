let table;

$(document).ready(function () {
  loadSubjects();
});

function loadSubjects() {
  table = $('#subjectTable').DataTable({
    destroy: true,
    ajax: {
      url: `../api/subjects_Api.php?action=list&academic_year_id=${academic_year_id}`,
      dataSrc: res => res.data
    },
    columns: [
      { data: 'id' },
      { data: 'subject_name' },
      { data: 'subject_code' },
      { data: 'class_name' },
      { data: 'status' },
      {
        data: 'id',
        render: id => `<button class="btn btn-sm btn-warning" onclick="openEditSubjectModal(${id})">Edit</button>`
      },
      {
        data: 'id',
        render: id => `<button class="btn btn-sm btn-danger" onclick="deleteSubject(${id})">Delete</button>`
      }
    ]
  });
}

function generateSubjectCode() {
  return 'SUB' + Math.floor(1000 + Math.random() * 9000);
}

function openAddSubjectModal() {
  $('#subjectForm')[0].reset();
  $('#subject_id').val('');
  $('#subject_code').val(generateSubjectCode()).prop('readonly', true);
  $('.modal-title').text('Add Subject');
  $('#subjectModal').modal('show');
}

function openEditSubjectModal(id) {
  $.getJSON(`../api/subjects_Api.php?action=read&id=${id}`, res => {
    if (res.success) {
      const s = res.data;
      $('#subject_id').val(s.id);
      $('#subject_name').val(s.subject_name);
      $('#subject_code').val(s.subject_code).prop('readonly', false);
      $('#class_id').val(s.class_id);
      $('#description').val(s.description);
      $('#status').val(s.status);
      $('.modal-title').text('Edit Subject');
      $('#subjectModal').modal('show');
    } else {
      Swal.fire('Error', res.message, 'error');
    }
  });
}

$('#subjectForm').submit(function (e) {
  e.preventDefault();
  const action = $('#subject_id').val() ? 'update' : 'create';
  $.post(`../api/subjects_Api.php?action=${action}`, $(this).serialize(), res => {
    if (res.success) {
      $('#subjectModal').modal('hide');
      table.ajax.reload();
      Swal.fire('Success', res.message, 'success');
    } else {
      Swal.fire('Error', res.message, 'error');
    }
  }, 'json');
});

function deleteSubject(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'This subject will be deleted.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then(result => {
    if (result.isConfirmed) {
      $.post(`../api/subjects_Api.php?action=delete`, { id }, res => {
        if (res.success) {
          table.ajax.reload();
          Swal.fire('Deleted!', res.message, 'success');
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      }, 'json');
    }
  });
  
}
