$(document).ready(function() {
    var table = $('#resultsTable').DataTable({
        "columns": [
            { "data": "no" },
            { "data": "student_name" },
            { "data": "class_name" },
            { "data": "exam_name" },
            { "data": "marks_obtained" },
            { "data": "total_marks" },
            { "data": "percentage" },
            { "data": "grade" },
            { "data": "actions" }
        ]
    });

    // Filter form submission
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var class_id = $('#class_id').val();
        var student_name = $('#student_name').val();

        $.ajax({
            url: '../api/exam_results_vew_api.php',
            type: 'GET',
            data: { action: 'fetch_results', class_id: class_id, student_name: student_name },
            dataType: 'json',
            success: function(response) {
                table.clear();
                response.forEach(function(item, index) {
                    table.row.add({
                        no: index+1,
                        student_name: item.student_name,
                        class_name: item.class_name,
                        exam_name: item.exam_name,
                        marks_obtained: item.marks_obtained,
                        total_marks: item.total_marks,
                        percentage: item.percentage + '%',
                        grade: item.grade,
                        actions: `<a href="../admin/student_results.php?student_id=${item.student_id}&student_name=${encodeURIComponent(item.student_name)}&class_name=${encodeURIComponent(item.class_name)}" 
                                  class="btn btn-info btn-sm">View more</a>`
                    });
                });
                table.draw();
            }
        });
    });
});
