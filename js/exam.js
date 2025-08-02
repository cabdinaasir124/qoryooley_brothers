$(document).ready(function () {
  let table;

  // 🟢 Fetch Exams and Populate Table
  function fetchExams() {
    $('#examTable tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');

    $.get('../api/exam_list_api.php?action=list_exams', function (data) {
      $('#examTable tbody').html(data);

      // 🔁 Reinitialize DataTable
      if ($.fn.DataTable.isDataTable('#examTable')) {
        $('#examTable').DataTable().destroy();
      }

      table = $('#examTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
          searchPlaceholder: "Search exams..."
        }
      });
    });
  }

  // 🔄 Initial Fetch
  fetchExams();

  // 📝 Handle Exam Form Submission
  $('#examForm').on('submit', function (e) {
    e.preventDefault();
    const form = document.getElementById('examForm');
    const formData = new FormData(form);

    // 🔁 Re-append multi-select class_ids[]
    const selectedClasses = form.querySelector('select[name="class_ids[]"]');
    formData.delete('class_ids[]'); // Clear any browser-default behavior
    Array.from(selectedClasses.selectedOptions).forEach(option => {
      formData.append('class_ids[]', option.value);
    });

    $.ajax({
      url: '../api/exam_list_api.php?action=create_exam',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          $('#createExamModal').modal('hide');
          $('#examForm')[0].reset();
          fetchExams();
          Toastify({ text: response.message, backgroundColor: "green", duration: 3000 }).showToast();
        } else {
          Toastify({ text: response.message, backgroundColor: "red", duration: 3000 }).showToast();
        }
      },
      error: function () {
        Toastify({ text: "Server error", backgroundColor: "red", duration: 3000 }).showToast();
      }
    });
  });
});
