$(document).ready(function () {
    let table;

    // Initialize DataTable
    function initializeTable() {
        table = $('#studentTable').DataTable({
            responsive: true,
            columns: [
                { title: "#" },
                { title: "Student Name" },
                { title: "Class" },
                { title: "Parent" },
                { title: "View" },
                { title: "Edit" },
                { title: "Delete" }
            ]
        });
    }

    // Fetch students and populate table
    function fetchStudents() {
        $.getJSON('../api/student_api.php?action=fetch', function (data) {
            table.clear();

            if (!data || data.length === 0) {
                const rowNode = table.row.add(['', '', '', '', '', '', '']).draw().node();
                $(rowNode).html(`<td colspan="7" class="text-center text-muted">No students found</td>`);
                return;
            }

            data.forEach((row, i) => {
                table.row.add([
                    i + 1,
                    row.full_name || '',
                    row.class_name || '',
                    row.parent_name || '',
                    `<button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</button>`,
                    `<button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</button>`,
                    `<button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>`
                ]);
            });

            table.draw();
        });
    }

    // Generate next student ID
    function generateStudentId() {
        $.getJSON('../api/student_api.php?action=generate_id', function (res) {
            $('input[name="student_id"]').val(res.student_id);
        });
    }

    // Show modal: generate ID
    $('#addStudentModal').on('show.bs.modal', function () {
        generateStudentId();
    });

    // Reset form when modal closes
    $('#addStudentModal').on('hidden.bs.modal', function () {
        $('#studentForm')[0].reset();
    });

    // Form submission
    $('#studentForm').submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: '../api/student_api.php?action=create',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#addStudentModal').modal('hide');
                    fetchStudents();
                    Swal.fire('Success', 'Student registered successfully!', 'success');
                } else {
                    Swal.fire('Error', res.message || 'Something went wrong', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Failed to connect to server', 'error');
            }
        });
    });

    // Initialize everything on page load
    initializeTable();
    fetchStudents();
});
