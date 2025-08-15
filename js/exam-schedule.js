document.addEventListener('DOMContentLoaded', function () {

    // Initialize DataTable globally
    let table = $('#examscheduleTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        columnDefs: [{ orderable: false, targets: 8 }],
        ajax: {
            url: '../api/exam_schedule_api.php',
            dataSrc: '',
            data: function(d) {
                d.action = 'list';
                d.class_filter = document.getElementById('filter_class').value;
                d.exam_type_filter = document.getElementById('filter_exam_type').value;
                d.academic_year_filter = document.querySelector('[name="academic_year_id"]').value;
            }
        },
        columns: [
            { data: null }, // # index
            { data: 'subject_name' },
            { data: 'class_name' },
            { data: 'exam_date' },
            { data: 'exam_date', render: function(data){ return new Date(data).toLocaleDateString('en-US', { weekday:'long' }); } },
            { data: 'exam_type' },
            { data: 'exam_start_time' },
            { data: 'exam_end_time' },
            { data: 'exam_id', render: function(data){ 
                return `
                    <button class="btn btn-sm btn-warning" onclick="editExam(${data})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteExam(${data})">Delete</button>
                `;
            } }
        ],
        order: [[3,'asc']],
        rowCallback: function(row, data, index){
            $('td:eq(0)', row).html(index+1); // Add serial number
        }
    });

    // Filters
    const filterClass = document.getElementById('filter_class');
    const filterExamType = document.getElementById('filter_exam_type');

    filterClass.addEventListener('change', ()=> table.ajax.reload());
    filterExamType.addEventListener('change', ()=> table.ajax.reload());

    // Open Add Modal
    window.openAddModal = function () {
        const form = document.getElementById('examForm');
        form.reset();
        document.getElementById('id').value = '';
        document.getElementById('examModalLabel').innerText = 'Add Exam';
        new bootstrap.Modal(document.getElementById('examModal')).show();
    }

    // Edit Exam
    window.editExam = function (id) {
        fetch(`../api/exam_schedule_api.php?action=get&id=${id}`)
            .then(res=>res.json())
            .then(data=>{
                document.getElementById('id').value = data.exam_id;
                document.getElementById('subject_id').value = data.subject_id;
                document.getElementById('class_id').value = data.class_id;
                document.getElementById('exam_date').value = data.exam_date;
                document.getElementById('exam_type').value = data.exam_type;
                document.getElementById('exam_start_time').value = data.exam_start_time;
                document.getElementById('exam_end_time').value = data.exam_end_time;
                document.getElementById('examModalLabel').innerText = 'Edit Exam';
                new bootstrap.Modal(document.getElementById('examModal')).show();
            });
    }

    // Delete Exam with SweetAlert
    window.deleteExam = function(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the exam!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result)=>{
            if(result.isConfirmed){
                const fd = new FormData();
                fd.append('action','delete');
                fd.append('id',id);
                fetch('../api/exam_schedule_api.php',{method:'POST',body:fd})
                    .then(res=>res.json())
                    .then(data=>{
                        if(data.status==='success'){
                            Swal.fire('Deleted!','Exam has been deleted.','success');
                            table.ajax.reload();
                        }else{
                            Swal.fire('Error','Failed to delete exam.','error');
                        }
                    });
            }
        });
    }

    // Submit Add/Edit Form
    const form = document.getElementById('examForm');
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const fd = new FormData(form);
        fd.append('action','save');

        fetch('../api/exam_schedule_api.php',{method:'POST',body:fd})
            .then(res=>res.json())
            .then(data=>{
                if(data.status==='success'){
                    bootstrap.Modal.getInstance(document.getElementById('examModal')).hide();
                    Swal.fire('Success','Exam saved successfully','success');
                    table.ajax.reload();
                }else{
                    Swal.fire('Error','Failed to save exam','error');
                }
            });
    });

});
