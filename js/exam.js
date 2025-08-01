function fetchExams() {
  $.get('../api/exam_list_api.php', function(data) {
    $('#examData').html(data);
  });
}

$('#examForm').submit(function(e) {
  e.preventDefault();
  const formData = $(this).serialize();
  $.post('../api/exam_create_process.php', formData, function(res) {
    const response = JSON.parse(res);
    if (response.status === 'success') {
      fetchExams();
      $('#examForm')[0].reset();
      $('#createExamModal').modal('hide');
    } else {
      alert('Error: ' + response.message);
    }
  });
});

$(document).ready(fetchExams);


$(document).ready(function () {
  function loadExams() {
    $('#examTable tbody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
    $.get('../api/exam_list_api.php', function (data) {
      $('#examTable tbody').html(data);
    });
  }

  loadExams();

  $('#examForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.post('../api/exam_create_process.php', formData, function (response) {
      if (response.status === 'success') {
        $('#createExamModal').modal('hide');
        $('#examForm')[0].reset();
        loadExams();
        Toastify({ text: response.message, backgroundColor: "green", duration: 3000 }).showToast();
      } else {
        Toastify({ text: response.message, backgroundColor: "red", duration: 3000 }).showToast();
      }
    }, 'json');
  });
});