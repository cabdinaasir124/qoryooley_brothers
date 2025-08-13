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
          <button data-bs-toggle="modal" data-bs-target="#updatehifzModal" class="btn btn-sm btn-primary edit-btn-hifz" data-id="${h.id}">
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
  $('#hifzTable').on('click', '.edit-btn-hifz', function () {
    let id = $(this).data('id');
    // alert('Edit record ID: ' + id);
    $.ajax({
      type: "POST",
      url: "../api/hifz_api.php?action=edit-hifz",
      data:{"id":id},
      dataType: "json",
      success: function (response) {
        if(response.status == "success"){
          var h=response.data;
          $("#UpdateHifzBody").html(`
             <form id="updatehifzForm">
              <div class="mb-3">
             <input type="text" hidden id="id" name="id" value='${h.id}' class="form-control" min="1" max="30" required>
                </div>
          <div class="mb-3">
            <label for="student_id" class="form-label">Student Name</label><br>
           <select id="update_student_id" name="student_id" class="form-control" required>
    <option value="${h.student_id}">${h.student_name}</option>
</select>
          </div>
          <div class="mb-3">
            <label for="juz_completed" class="form-label">Juz Completed</label>
            <input type="number" id="juz_completed" name="juz_completed" value='${h.juz_completed}' class="form-control" min="1" max="30" required>
          </div>
          <div class="mb-3">
            <label for="last_surah" class="form-label">Last Surah</label>
            <input type="text" id="last_surah" name="last_surah" value='${h.last_surah}' class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="revision_notes" class="form-label">Revision Notes</label>
<textarea id="revision_notes" name="revision_notes" class="form-control" rows="3">${h.revision_notes}</textarea>
          </div>
          <button type="submit" class="btn btn-success w-100">Save</button>
        </form>
            
            `)
            // Show modal
          $('#updatehifzModal').modal('show');
        }else{
                    alert("Failed to fetch Hifz info.");

        }
        
        
      }
    });
  });

  $('#hifzTable').on('click', '.delete-btn-hifz', function () {
    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this record?')) {
        $.post('../api/hifz_api.php?action=delete_hifz', { id }, function(res) {
            if (res.success) {
                Toastify({
                    text: res.message,
                    duration: 3000,
                    backgroundColor: "green",
                    close: true
                }).showToast();

                loadHifz(); // Dib u cusbooneysii table-ka
            } else {
                Toastify({
                    text: "Error: " + res.message,
                    duration: 3000,
                    backgroundColor: "red",
                    close: true
                }).showToast();
            }
        }, 'json');
    }
});
// Submit update form
$(document).on('submit', '#updatehifzForm', function(e) {
    e.preventDefault();

    // Add hidden ID input inside form or pass separately
    let formData = $(this).serialize() + "&id=" + $(".edit-btn-hifz").data('id');

    $.post('../api/hifz_api.php?action=update_hifz', formData, function(res) {
        if (res.status === 'success') {
            $('#updatehifzModal').modal('hide');
            loadHifz();
            Toastify({
                text: res.message,
                duration: 3000,
                backgroundColor: "green"
            }).showToast();
        } else {
            Toastify({
                text: res.message,
                duration: 3000,
                backgroundColor: "red"
            }).showToast();
        }
    }, 'json');
});


});
