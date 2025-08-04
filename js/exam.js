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


  //  Exam Delete Start Here
 // ✅ Kani sax ayuu noqonayaa
$('#examTable').on("click", ".examDelete", function (e) {
  e.preventDefault();
  const id = $(this).attr('exam-id');
  if (!id) {
    Toastify({ text: "Missing exam ID", backgroundColor: "red", duration: 3000 }).showToast();
    return;
  }

  if (!confirm("Are you sure you want to delete this exam?")) return;

  $.ajax({
    url: '../api/exam_list_api.php?action=delete_exam',
    type: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (response) {
      if (response.status === 'success') {
        Toastify({ text: response.message, backgroundColor: "green", duration: 3000 }).showToast();
          fetchExams();
      } else {
        Toastify({ text: response.message, backgroundColor: "red", duration: 3000 }).showToast();
      }
    },
    error: function () {
      Toastify({ text: "Server error", backgroundColor: "red", duration: 3000 }).showToast();
    }
  });
});
  //  Exam Delete End Here
  //  Exam Update Start Here
// edit button click
$(document).on('click', '.examEdit', function () {
  const examId = $(this).attr('exam-id');
  $.ajax({
    url: "../api/exam_list_api.php",
    type: "GET",
    data: { action: "ReadUpdate_exam", id: examId },
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        $("#updateExamModal .modal-body").html(res.html);
        $("#updateExamModal").modal("show");
      } else {
        alert(res.message || "Failed to load exam form");
      }
    }
  });
});

  //  Exam Update End Here

  $(document).on('submit', '#examFormUpdate', function (e) {
  e.preventDefault();
  const formData = $(this).serialize();

  $.ajax({
    url: "../api/exam_list_api.php?action=update_exam",
    type: "POST",
    data: formData,
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        $("#updateExamModal").modal("hide");
        fetchExams(); // refresh list
        Toastify({ text: res.message, backgroundColor: "green" }).showToast();
      } else {
        Toastify({ text: res.message || "Failed to update", backgroundColor: "red" }).showToast();
      }
    }
  });
});



});
