document.addEventListener("DOMContentLoaded", function () {
  // Load Summary Stats (Girls, Boys, Expenses, Activities)
  fetch("../api/dashboard_api.php?action=summary_stats")
    .then(res => res.json())
    .then(data => {
      document.getElementById("girlCount").innerText = data.girls;
      document.getElementById("boyCount").innerText = data.boys;
      document.getElementById("expenseTotal").innerText = "$" + data.expenses;
      document.getElementById("otherActivities").innerText = data.activities;
      document.getElementById("countTeacher").innerText = data.teachers;
    })
    .catch(err => {
      console.error("Summary stats error:", err);
      document.getElementById("girlCount").innerText = "Error";
      document.getElementById("boyCount").innerText = "Error";
      document.getElementById("expenseTotal").innerText = "Error";
      document.getElementById("otherActivities").innerText = "Error";
      document.getElementById("countTeacher").innerText = "Error";
    });

  // Load Enrollment Stats Chart
  fetch("../api/dashboard_api.php?action=enrollment_stats")
    .then(res => res.json())
    .then(data => {
      const classNames = data.map(item => item.class);
      const studentCounts = data.map(item => item.count);

      const options = {
        chart: {
          type: "bar",
          height: 360,
          toolbar: { show: false }
        },
        series: [{
          name: "Total Students",
          data: studentCounts
        }],
        colors: ["#0066cc"],
        xaxis: {
          categories: classNames,
          title: { text: "Classes" }
        },
        yaxis: {
          title: { text: "Number of Students" }
        },
        dataLabels: { enabled: true },
        title: {
          text: "Enrollment per Class",
          align: "left",
          style: { fontSize: "16px", fontWeight: "bold" }
        }
      };

      const chart = new ApexCharts(document.querySelector("#student-statistics"), options);
      chart.render();
    })
    .catch(err => {
      console.error("Chart error:", err);
      document.getElementById("student-statistics").innerHTML = "<p class='text-muted'>Failed to load chart data.</p>";
    });

  // Load Task List
  fetch("../api/dashboard_api.php?action=tasks")
    .then(res => res.json())
    .then(tasks => {
      const taskList = document.getElementById("taskList");
      taskList.innerHTML = "";

      if (tasks.length === 0) {
        taskList.innerHTML = '<li><p class="text-muted">No upcoming tasks found.</p></li>';
      } else {
        tasks.forEach(task => {
          const checked = task.is_done == 1 ? "checked" : "";
          taskList.innerHTML += `
            <li>
              <div class="d-flex mb-2 pb-1 border-bottom">
                <div class="form-check me-2">
                  <input type="checkbox" class="form-check-input" ${checked}>
                </div>
                <div class="flex-fill w-100">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <h6 class="fw-semibold text-dark mb-1">${task.title}</h6>
                      <p class="text-muted small mb-0">${task.due_date}</p>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm">Edit</button>
                  </div>
                </div>
              </div>
            </li>`;
        });
      }
    })
    .catch(err => {
      console.error("Task list error:", err);
      document.getElementById("taskList").innerHTML = '<li><p class="text-danger">Failed to load tasks.</p></li>';
    });
});
