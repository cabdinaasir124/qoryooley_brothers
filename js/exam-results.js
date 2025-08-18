$(document).ready(function () {
  let table;

  // Load Students
  $('#loadStudents').click(function () {
      const academic_year_id = $('#academic_year_id').val();
      const class_id = $('#class_id').val();
      const exam_id = $('#exam_id').val();
      const subject_id = $('#subject_id').val();

      if (!academic_year_id || !class_id || !exam_id || !subject_id) {
          Swal.fire("⚠️ Missing Filters", "Please select: Academic Year, Class, Exam and Subject.", "warning");
          return;
      }

      $.get('../api/exam_results_api.php', {
          action: 'get_students',
          academic_year_id,
          class_id,
          exam_id,
          subject_id
      }, function (resp) {
          if (resp.status !== 'success') {
              Swal.fire("❌ Error", resp.message || "Failed to load students.", "error");
              return;
          }

          if (table) table.destroy();
          $('#resultsTable tbody').empty();

          let rows = '';
          resp.data.forEach((s, i) => {
              rows += `
                <tr>
                  <td>${i + 1}</td>
                  <td>${s.student_id}</td>
                  <td>${s.name}</td>
                  <td>
                    <input type="number" class="form-control marks-input" 
                           data-student="${s.student_id}" min="0" max="100" step="0.01" placeholder="Enter marks"
                           value="${s.existing_marks !== null ? s.existing_marks : ''}">
                  </td>
                </tr>
              `;
          });

          $('#resultsTable tbody').html(rows);
          table = $('#resultsTable').DataTable({ responsive: true });
      }, 'json')
      .fail(function(xhr){
          Swal.fire("❌ Error", xhr.responseText || "Request failed.", "error");
      });
  });

  // Save Results
  $('#saveResults').click(function () {
      const academic_year_id = $('#academic_year_id').val();
      const class_id = $('#class_id').val();
      const exam_id = $('#exam_id').val();
      const subject_id = $('#subject_id').val();

      let results = [];
      $('.marks-input').each(function () {
          const student_id = $(this).data('student');
          const marks = $(this).val();
          if (marks !== '') {
              results.push({ student_id, marks });
          }
      });

      if (results.length === 0) {
          Swal.fire("⚠️ Empty!", "Please enter marks before saving!", "warning");
          return;
      }

      $.post('../api/exam_results_api.php', {
          action: 'save_results',
          academic_year_id, class_id, exam_id, subject_id,
          results: JSON.stringify(results)
      }, function (resp) {
          if (resp.status === 'success') {
              Swal.fire("✅ Success", resp.message, "success");
          } else {
              Swal.fire("❌ Error", resp.message || "Could not save results.", "error");
          }
      }, 'json')
      .fail(function(xhr){
          Swal.fire("❌ Error", xhr.responseText || "Request failed.", "error");
      });
  });
});