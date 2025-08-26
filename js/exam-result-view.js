$(document).ready(function () {
    var table = $('#resultsTable').DataTable({
        columns: [
            { data: "no", defaultContent: "" },
            { data: "student_name", defaultContent: "" },
            { data: "class_name", defaultContent: "" },
            { data: "exam_name", defaultContent: "" },
            { data: "marks_obtained", defaultContent: "" },
            { data: "total_marks", defaultContent: "" },
            { data: "percentage", defaultContent: "" },
            { data: "grade", defaultContent: "" },
            { data: "actions", orderable: false, searchable: false, defaultContent: "" }
        ]
    });

    // Filter form submission
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var class_id = $('#class_id').val();
        var student_name = $('#student_name').val();

        $.ajax({
            url: '../api/exam_results_vew_api.php',
            type: 'GET',
            data: { 
                action: 'fetch_results', 
                class_id: class_id, 
                student_name: student_name 
            },
            dataType: 'json',
            success: function (response) {
                table.clear();

                response.forEach(function (item, index) {
                    table.row.add({
                        no: index + 1,
                        student_name: item.student_name ?? "",
                        class_name: item.class_name ?? "",
                        exam_name: item.exam_name ?? "",  // <- MUST EXIST in API response
                        marks_obtained: item.marks_obtained ?? "",
                        total_marks: item.total_marks ?? "",
                        percentage: (item.percentage ?? "") + "%",
                        grade: item.grade ?? "",
                        actions: `
                            <a href="../admin/student_results.php?student_id=${item.student_id}
                            &student_name=${encodeURIComponent(item.student_name ?? "")}
                            &class_name=${encodeURIComponent(item.class_name ?? "")}" 
                            class="btn btn-info btn-sm">View more</a>
                        `
                    });
                });

                table.draw();
            }
        });
    });
});
