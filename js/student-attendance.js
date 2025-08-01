document.addEventListener("DOMContentLoaded", function () {
  const classFilter = document.getElementById("classFilter");
  const studentSelect = document.getElementById("studentSelect");

  classFilter.addEventListener("change", function () {
    const className = this.value;
    studentSelect.innerHTML = '<option value="">Loading...</option>';

    fetch(`../api/get_students_by_class.php?class_name=${encodeURIComponent(className)}`)
      .then(response => response.json())
      .then(data => {
        studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
        if (data.length === 0) {
          studentSelect.innerHTML += '<option value="">No students found</option>';
        } else {
          data.forEach(student => {
            const opt = document.createElement("option");
            opt.value = student.id;
            opt.textContent = student.full_name;
            studentSelect.appendChild(opt);
          });
        }
      })
      .catch(error => {
        console.error("Error loading students:", error);
        studentSelect.innerHTML = '<option value="">Error loading students</option>';
      });
  });


   $('#attendanceForm').on('submit', function (e) {
    e.preventDefault();

    const studentId = $('#studentSelect').val();
    const date = $('#attendanceDate').val();
    const status = $('select[name="status"]').val();

    if (!studentId || !date || !status) {
      alert("❗ All fields are required.");
      return;
    }

    $.ajax({
      url: '../api/save_attendance.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        student_id: studentId,
        date: date,
        status: status
      }),
      success: function (response) {
        if (response.status === 'success') {
          alert(response.message);
          location.reload(); // refresh to show updated table
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert("❌ Server error occurred.");
      }
    });
  });

  $('#attendanceTable').DataTable({
      responsive: true,
      pageLength: 10,
      lengthChange: false,
      order: [[3, 'desc']], // Sort by date descending
    });
});
