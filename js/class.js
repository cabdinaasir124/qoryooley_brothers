$(document).ready(function () {
     let table;

    function getAcademicYearId() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('academic_year_id');
    }

    function initializeDataTable() {
        table = $('#row-callback-datatable').DataTable({
            destroy: true,
            responsive: true,
            data: [],
            columns: [
                { data: null, title: '#', render: (data, type, row, meta) => meta.row + 1 },
                { data: 'class_name', title: 'Class Name' },
                { data: 'description', title: 'Description' },
                { data: 'max_students', title: 'Max Students' },
                {
                    data: 'days_active',
                    title: 'Days Active',
                    render: (data) => Array.isArray(data) ? data.join(', ') : ''
                },
                {
                    data: 'status',
                    title: 'Status',
                    render: (data) =>
                        data === 'ongoing'
                            ? `<span class="badge bg-success-subtle text-success">Ongoing</span>`
                            : `<span class="badge bg-danger-subtle text-danger">Completed</span>`
                },
                {
                    data: null,
                    title: 'Update',
                    orderable: false,
                    render: (data, type, row) =>
                        `<button class="btn btn-sm btn-warning update-btn" data-id="${row.id}"><i class="fas fa-edit"></i></button>`
                },
                {
                    data: null,
                    title: 'Delete',
                    orderable: false,
                    render: (data, type, row) =>
                        `<button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>`
                }
            ]
        });
    }

    function fetchClasses() {
        const yearId = getAcademicYearId();
        if (!yearId) return;

        fetch(`../api/class_Api.php?academic_year_id=${yearId}`)
            .then(res => res.json())
            .then(response => {
                if (response.status === "success" && Array.isArray(response.data)) {
                    if (!table) {
                        initializeDataTable();
                    }
                    table.clear().rows.add(response.data).draw();
                } else {
                    toastr.warning("No class data found.");
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                toastr.error("Error loading classes.");
            });
    }

    // // Init
    // fetchClasses();

    $(document).on("click", "#addNewBtn", function () {
    $("#classForm")[0].reset(); // Clear all fields
    $("#class_id").val(""); // Clear the hidden ID field
    $("input[name='days_active[]']").prop("checked", false); // Uncheck all days
    $("#classModal").modal("show"); // Show modal
});


    // Handle Form Submission
    $(document).on("submit", "#classForm", function (e) {
        e.preventDefault();
        let formdata = new FormData(this);
        $.ajax({
            type: "POST",
            url: "../api/class_Api.php",
            data: formdata,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#classModal").modal("hide");
                    
                    $("#classForm")[0].reset();
                    toastr.success(response.message);
                    fetchClasses();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error("Form submission failed.");
            }
        });
    });

    // Delete with SweetAlert
    $(document).on("click", ".delete-btn", function () {
        const classId = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won’t be able to recover this class!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../api/class_Api.php', {
                    method: 'DELETE',
                    body: new URLSearchParams({ id: classId })
                })
                    .then(res => res.json())
                    .then(response => {
                        if (response.status === "success") {
                            toastr.success("Class deleted successfully.");
                            fetchClasses();
                        } else {
                            toastr.error("Failed to delete class.");
                        }
                    })
                    .catch(() => toastr.error("Delete request failed."));
            }
        });
    });

   $(document).on("click", ".update-btn", function () {
    const classId = $(this).data("id");

    fetch(`../api/class_Api.php?id=${classId}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === "success" && Array.isArray(data.data) && data.data.length > 0) {
                const cls = data.data[0]; // ✅ FIXED

                // Fill form
                $("#class_id").val(cls.id);
                $("input[name='class_name']").val(cls.class_name);
                $("textarea[name='description']").val(cls.description);
                $("input[name='max_students']").val(cls.max_students);
                $("select[name='status']").val(cls.status);

                // Clear all day checkboxes first
                $("input[name='days_active[]']").prop("checked", false);

                // Check the relevant days
                cls.days_active.forEach(day => {
                    $(`input[name='days_active[]'][value='${day}']`).prop("checked", true);
                });

                // Show modal
                $("#classModal").modal("show");
            } else {
                toastr.error("Failed to load class for update.");
            }
        })
        .catch(() => toastr.error("Error fetching class data."));
});


    // Initial load
    fetchClasses();
});


