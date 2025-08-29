$(document).ready(function () {
    All_students();
    function All_students(){
        $.ajax({
            type: "POST",
            url: "../api/t_dashboard_api.php",
            data:{"action":"all_students"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#Stotal").html(response.message);
            }
        });
    }
    All_attendence();
    function All_attendence(){
        $.ajax({
            type: "POST",
            url: "../api/t_dashboard_api.php",
            data:{"action":"allattendence"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#atendenceTotal").html(response.message);
            }
        });
    }
    Exam_total();
    function Exam_total(){
        $.ajax({
            type: "POST",
            url: "../api/t_dashboard_api.php",
            data:{"action":"All_exam"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#examTotal").html(response.message);
            }
        });
    }
    All_classes();
    function All_classes(){
        $.ajax({
            type: "POST",
            url: "../api/t_dashboard_api.php",
            data:{"action":"class_total"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#Allclasses").html(response.message);
            }
        });
    }
    All_teachers();
    function All_teachers(){
        $.ajax({
            type: "POST",
            url: "../api/t_dashboard_api.php",
            data:{"action":"Allteachers"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#All_teachers").html(response.message);
            }
        });
    }

    // Fetch published exams count & progress
fetch('api.php?action=published_exams')
  .then(res => res.json())
  .then(data => {
    // Update count
    document.getElementById('publishedExamsCount').textContent = data.count;

    // Update progress bar
    const progressBar = document.getElementById('publishedExamsProgress');
    progressBar.style.width = data.progress + '%';
    progressBar.textContent = data.progress + '%';
  })
  .catch(err => console.error('Error fetching published exams:', err));


});