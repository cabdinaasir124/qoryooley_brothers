document.addEventListener('DOMContentLoaded', function(){

    const tableBody = document.querySelector('#examSubjectsTable tbody');
    const form = document.getElementById('examSubjectForm');

    // Load table
    function loadSubjects(){
        fetch('../api/exam_subjects_api.php?action=list')
        .then(res => res.json())
        .then(data => {
            tableBody.innerHTML = '';
            data.forEach(row => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.exam_type}</td>
                        <td>${row.subject_name}</td>
                        <td>${row.full_name}</td>
                        <td>${row.class_name}</td>
                        <td>${row.year_name}</td>
                        <td>${row.exam_date}</td>
                        <td>${row.max_marks}</td>
                        <td><button class="btn btn-sm btn-warning" onclick="editSubject(${row.id})">✏️ Edit</button></td>
                        <td><button class="btn btn-sm btn-danger" onclick="deleteSubject(${row.id})">🗑️ Delete</button></td>
                    </tr>
                `;
            });
        });
    }

    loadSubjects();

    // Open modal
    window.openAddSubjectModal = function(){
        form.reset();
        form.subject_id.value = '';
        document.querySelector('#subjectModal .modal-title').textContent = 'Add Exam Subject';
        new bootstrap.Modal(document.getElementById('subjectModal')).show();
    }

    // Edit
    window.editSubject = function(id){
        fetch('../api/exam_subjects_api.php?action=get&id='+id)
        .then(res=>res.json())
        .then(data=>{
            form.subject_id.value = data.id;
            form.exam_id.value = data.exam_id;
            form.subject_id_select.value = data.subject_id;
            form.teacher_id.value = data.teacher_id;
            form.class_id.value = data.class_id;
            form.academic_year_id.value = data.academic_year_id;
            form.exam_date.value = data.exam_date;
            form.max_marks.value = data.max_marks;

            document.querySelector('#subjectModal .modal-title').textContent = 'Edit Exam Subject';
            new bootstrap.Modal(document.getElementById('subjectModal')).show();
        });
    }

    // Delete
    window.deleteSubject = function(id){
        if(confirm('Delete this record?')){
            fetch('../api/exam_subjects_api.php?action=delete',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:'id='+id
            }).then(res=>res.json())
            .then(res=>{
                if(res.status=='success') loadSubjects();
            });
        }
    }

    // Save
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(form);
        formData.append('action','save');

        fetch('../api/exam_subjects_api.php',{
            method:'POST',
            body: formData
        }).then(res=>res.json())
        .then(res=>{
            if(res.status=='success'){
                bootstrap.Modal.getInstance(document.getElementById('subjectModal')).hide();
                loadSubjects();
            }
        });
    });

});
