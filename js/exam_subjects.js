document.addEventListener('DOMContentLoaded', function () {
  const tableBody = document.querySelector('#examSubjectsTable tbody');
  const form = document.getElementById('examSubjectForm');
  const modalEl = document.getElementById('subjectModal');
  let modal;

  function ensureModal() {
    if (!modal) modal = new bootstrap.Modal(modalEl);
  }

  function rowHtml(row) {
    const examLabel = `${row.exam_type} - ${row.exam_title}`;
    return `
      <tr>
        <td>${row.id}</td>
        <td>${examLabel}</td>
        <td>${row.subject_name}</td>
        <td>${row.full_name}</td>
        <td>${row.class_name}</td>
        <td>${row.year_name}</td>
        <td>${row.exam_date ?? ''}</td>
        <td>${row.max_marks ?? ''}</td>
        <td><button class="btn btn-sm btn-warning" data-id="${row.id}" data-action="edit">✏️ Edit</button></td>
        <td><button class="btn btn-sm btn-danger" data-id="${row.id}" data-action="delete">🗑️ Delete</button></td>
      </tr>
    `;
  }

  function loadSubjects() {
    fetch('../api/exam_subjects_api.php?action=list')
      .then(res => res.json())
      .then(data => {
        tableBody.innerHTML = data.map(rowHtml).join('');
      });
  }

  // Delegated clicks for edit/delete
  tableBody.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-action]');
    if (!btn) return;
    const id = btn.getAttribute('data-id');
    const action = btn.getAttribute('data-action');
    if (action === 'edit') {
      editSubject(id);
    } else if (action === 'delete') {
      deleteSubject(id);
    }
  });

  window.openAddSubjectModal = function () {
    form.reset();
    form.querySelector('#row_id').value = '';
    document.querySelector('#subjectModal .modal-title').textContent = 'Add Exam Subject';
    ensureModal();
    modal.show();
  };

  function editSubject(id) {
    fetch('../api/exam_subjects_api.php?action=get&id=' + id)
      .then(res => res.json())
      .then(data => {
        if (!data) return;
        // Hidden row id
        form.querySelector('#row_id').value = data.id;
        // Assign selects/inputs
        form.querySelector('#exam_id').value = data.exam_id;
        form.querySelector('#subject_id').value = data.subject_id;
        form.querySelector('#teacher_id').value = data.teacher_id;
        form.querySelector('#class_id').value = data.class_id;
        form.querySelector('#academic_year_id').value = data.academic_year_id;
        form.querySelector('#exam_date').value = data.exam_date ?? '';
        form.querySelector('#max_marks').value = data.max_marks ?? '';

        document.querySelector('#subjectModal .modal-title').textContent = 'Edit Exam Subject';
        ensureModal();
        modal.show();
      });
  }
  window.editSubject = editSubject;

  function deleteSubject(id) {
    if (!confirm('Delete this record?')) return;
    fetch('../api/exam_subjects_api.php?action=delete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') loadSubjects();
    });
  }
  window.deleteSubject = deleteSubject;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const fd = new FormData(form);
    fd.append('action', 'save');

    fetch('../api/exam_subjects_api.php', {
      method: 'POST',
      body: fd
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        ensureModal();
        modal.hide();
        loadSubjects();
      }
    });
  });

  // init
  loadSubjects();
});
