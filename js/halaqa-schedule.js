const apiURL = '../api/halaqa_api.php';
let halaqaTable;

// Fetch all halaqas and load DataTable
function loadHalaqas() {
  fetch(`${apiURL}?action=fetch`)
    .then(res => res.json())
    .then(data => {
      let rows = '';
      data.forEach((item, index) => {
        rows += `
          <tr>
            <td>${index + 1}</td>
            <td>${item.day}</td>
            <td>${item.time}</td>
            <td>${item.subject}</td>
            <td>${item.teacher}</td>
            <td>
              <button class="btn btn-sm btn-warning" onclick='openEditModal(${JSON.stringify(item)})'>
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="deleteHalaqa(${item.id})">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        `;
      });

      // Destroy and re-init DataTable
      if (halaqaTable) {
        halaqaTable.destroy();
      }
      document.getElementById('halaqaTableBody').innerHTML = rows;
      halaqaTable = $('#halaqaTable').DataTable();
    });
}

// Open modal for Add
function openAddModal() {
  document.getElementById('halaqaForm').reset();
  document.getElementById('id').value = '';
  document.getElementById('halaqaModalLabel').textContent = 'Add Halaqa';
}

// Open modal for Edit
function openEditModal(data) {
  document.getElementById('id').value = data.id;
  document.getElementById('day').value = data.day;
  document.getElementById('time').value = data.time;
  document.getElementById('subject').value = data.subject;
  document.getElementById('teacher').value = data.teacher;
  document.getElementById('halaqaModalLabel').textContent = 'Edit Halaqa';
  new bootstrap.Modal(document.getElementById('halaqaModal')).show();
}

// Save halaqa (Add/Edit)
document.getElementById('halaqaForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const action = formData.get('id') ? 'update' : 'create';
  fetch(`${apiURL}?action=${action}`, { method: 'POST', body: formData })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        loadHalaqas();
        bootstrap.Modal.getInstance(document.getElementById('halaqaModal')).hide();
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: res.message
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: res.message || 'Error saving halaqa'
        });
      }
    });
});

// Delete halaqa with confirmation
function deleteHalaqa(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to undo this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('id', id);
      fetch(`${apiURL}?action=delete`, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            loadHalaqas();
            Swal.fire('Deleted!', res.message, 'success');
          } else {
            Swal.fire('Error!', res.message || 'Error deleting halaqa', 'error');
          }
        });
    }
  });
}

// Init
document.addEventListener('DOMContentLoaded', () => {
  loadHalaqas();
});
