</div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

     <script src="sweetalert2.all.min.js"></script>
    <!-- Apexcharts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Widgets Init Js -->
    <script src="../assets/js/pages/projects-dashboard.init.js"></script>

    <script>
    const academic_year_id = "<?= $academic_year_id ?>";
    </script>

    <!-- Datatables js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

        <!-- dataTables.bootstrap5 -->
        <script src="../assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="../assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    
        
        <!-- dataTables.keyTable -->
        <script src="../assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>

        <!-- dataTable.responsive -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

        <!-- dataTables.select -->
        <script src="../assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

        <!-- Datatable Demo App Js -->
        <script src="../assets/js/pages/datatable.init.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js-->
    <script src="../assets/js/app.js"></script>
    <script src="../js/users.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/class.js"></script>
    <script src="../js/subject.js"></script>
    <script src="../js/c_schedule.js"></script>
    <script src="../js/c_schedule.js"></script>
    <script src="../js/c_schedule.js"></script>
    <script src="../js/parent_list.js"></script>
    <script src="../js/student.js"></script>
    <script src="../js/student-id.js"></script>
    <script src="../js/dashboard.js"></script>
    <script src="../js/leave_cert.js"></script>
    <script src="../js/student-attendance.js"></script>
    <script src="../js/notification.js"></script>
    <script src="../js/exam.js"></script>
    <script src="../js/teacher.js"></script>
    <script src="../js/expenses.js"></script>
    <script src="../js/hifz.js"></script>
    <script src="../js/halaqa-schedule.js"></script>
    <script src="../js/tajweed.js"></script>
    <script src="../js/exam-schedule.js"></script>

    <script>
        document.querySelector('.feather-menu').addEventListener('click', () => {
  document.body.classList.toggle('sidebar-collapsed');
});

    </script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Assignments Chart
  new Chart(document.getElementById('assignmentsChart'), {
    type: 'doughnut',
    data: {
      labels: ['Marked', 'Unmarked'],
      datasets: [{
        data: [12, 3],
        backgroundColor: ['#28a745', '#dc3545'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });

  // Exam Line Chart
  new Chart(document.getElementById('examChart'), {
    type: 'line',
    data: {
      labels: ['Term 1', 'Term 2', 'Term 3'],
      datasets: [{
        label: 'Score (%)',
        data: [75, 82, 91],
        fill: true,
        borderColor: '#17a2b8',
        backgroundColor: 'rgba(23, 162, 184, 0.2)',
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, max: 100 }
      }
    }
  });

  // Attendance Pie Chart
  new Chart(document.getElementById('attendanceChart'), {
    type: 'pie',
    data: {
      labels: ['Present', 'Absent'],
      datasets: [{
        data: [92, 8],
        backgroundColor: ['#007bff', '#ffc107'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>


<!-- XLSX (SheetJS) for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- jsPDF & autoTable for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
  // 📊 Grade Distribution Bar Chart
  new Chart(document.getElementById('gradeBarChart'), {
    type: 'bar',
    data: {
      labels: ['A+', 'A', 'B', 'C', 'D', 'F'],
      datasets: [{
        label: 'Number of Subjects',
        data: [3, 2, 1, 0, 0, 0],
        backgroundColor: [
          '#28a745', '#20c997', '#ffc107', '#fd7e14', '#dc3545', '#6c757d'
        ]
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      },
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Grade Distribution'
        }
      }
    }
  });

  // 📈 Monthly Attendance Line Chart
  new Chart(document.getElementById('monthlyAttendanceChart'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Attendance (%)',
        data: [90, 88, 94, 92, 96, 89],
        fill: true,
        borderColor: '#007bff',
        backgroundColor: 'rgba(0,123,255,0.1)',
        tension: 0.4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, max: 100 }
      },
      plugins: {
        legend: { position: 'top' },
        title: {
          display: true,
          text: 'Monthly Attendance'
        }
      }
    }
  });

  // 📡 Subject-wise Performance Radar Chart
  new Chart(document.getElementById('subjectRadarChart'), {
    type: 'radar',
    data: {
      labels: ['Math', 'English', 'Science', 'History', 'Geography', 'ICT'],
      datasets: [{
        label: 'Score (%)',
        data: [88, 76, 90, 70, 80, 85],
        fill: true,
        backgroundColor: 'rgba(255,193,7,0.3)',
        borderColor: '#ffc107',
        pointBackgroundColor: '#ffc107'
      }]
    },
    options: {
      responsive: true,
      scales: {
        r: {
          angleLines: { display: true },
          suggestedMin: 0,
          suggestedMax: 100
        }
      },
      plugins: {
        title: {
          display: true,
          text: 'Subject-wise Performance'
        }
      }
    }
  });
</script>







    
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col fs-13 text-muted text-center">
                            &copy; <script>document.write(new Date().getFullYear())</script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a href="#!" class="text-reset fw-semibold">Eng Abdinaasir mohamed and Eng Ali ibraahim</a> 
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
<!-- jQuery (already included for DataTables) -->
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    </body>

</html>