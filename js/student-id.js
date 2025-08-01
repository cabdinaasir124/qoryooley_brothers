
document.addEventListener("DOMContentLoaded", function () {
  const cardContainer = document.getElementById("cardContainer");
  const classFilter = document.getElementById("classFilter");
  const searchInput = document.getElementById("searchInput");
  const paginationContainer = document.getElementById("pagination");
  const noDataMessage = document.getElementById("noDataMessage");

  let allStudents = [];
  let filteredStudents = [];
  let currentPage = 1;
  const studentsPerPage = 3; // each student = 2 cards

  const academicYearId = 1; // Can be dynamic

  // Load class options from API
  function loadClassOptions() {
    fetch("../api/class_Api.php")
      .then(response => response.json())
      .then(classes => {
        classes.forEach(cls => {
          const option = document.createElement("option");
          option.value = cls.class_name;
          option.textContent = cls.class_name;
          classFilter.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error loading classes:", error);
      });
  }

  // Load students from API
  function loadStudents() {
    fetch(`../api/student_api.php?action=fetch&academic_year_id=${academicYearId}`)
      .then(res => res.json())
      .then(students => {
        allStudents = students;
        applyFilters();
      });
  }

  // Filter based on class & search
  function applyFilters() {
    const classValue = classFilter.value.toLowerCase();
    const searchText = searchInput.value.toLowerCase();

    filteredStudents = allStudents.filter(student => {
      const classMatch = classValue === "" || student.class_name.toLowerCase() === classValue;
      const searchMatch =
        student.full_name.toLowerCase().includes(searchText) ||
        student.student_id.toLowerCase().includes(searchText) ||
        student.class_name.toLowerCase().includes(searchText);
      return classMatch && searchMatch;
    });

    currentPage = 1;
    renderPagination();
    renderCards();
  }

  // Pagination Buttons
  function renderPagination() {
    paginationContainer.innerHTML = "";
    const totalPages = Math.ceil(filteredStudents.length / studentsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = `page-btn ${i === currentPage ? "active" : ""}`;
      btn.style.margin = "5px";
      btn.style.padding = "5px 10px";
      btn.style.border = "none";
      btn.style.borderRadius = "5px";
      btn.style.background = i === currentPage ? "#0066cc" : "#003366";
      btn.style.color = "#fff";

      btn.onclick = () => {
        currentPage = i;
        renderCards();
        renderPagination();
      };

      paginationContainer.appendChild(btn);
    }

    cardContainer.after(paginationContainer);
  }

  // Render student ID cards
  function renderCards() {
    cardContainer.innerHTML = "";

    if (filteredStudents.length === 0) {
      noDataMessage.style.display = "block";
      paginationContainer.style.display = "none";
      return;
    } else {
      noDataMessage.style.display = "none";
      paginationContainer.style.display = "block";
    }

    const startIndex = (currentPage - 1) * studentsPerPage;
    const endIndex = startIndex + studentsPerPage;
    const studentsToShow = filteredStudents.slice(startIndex, endIndex);

    studentsToShow.forEach((student, index) => {
      const academicYear = student.academic_year || "2025/2026";
      const [startYear, endYear] = academicYear.split("/").map(Number);
      const expiryYear = `${endYear}/${endYear + 1}`;
      const qrValue = `Name: ${student.full_name}\nID: ${student.student_id}\nClass: ${student.class_name}\nAcademic Year: ${academicYear}`;

      const front = `
        <div class="id-card-page">
          <div class="id-card front">
            <div class="header">
              <img src="../assets/images/logo.jpg" class="school-logo" alt="Logo">
              <div class="school-info">
                <h2>Qoryooley Brothers School</h2>
                <small>Student ID Card - Front</small>
              </div>
            </div>
            <div class="photo-section">
              <img src="${student.student_image}" class="student-photo">
            </div>
            <table class="info-table">
              <tr><th>Full Name</th><td>${student.full_name}</td></tr>
              <tr><th>Student ID</th><td>${student.student_id}</td></tr>
              <tr><th>Class</th><td>${student.class_name}</td></tr>
              <tr><th>Academic Year</th><td>${academicYear}</td></tr>
              <tr><th>Expire Date</th><td>${expiryYear}</td></tr>
            </table>
            <div class="footer-note">
              <small>Issued by: Qoryooley Brothers School</small>
            </div>
          </div>
        </div>`;

      const back = `
        <div class="id-card-page">
          <div class="id-card back">
            <div class="header back-header">
              <h2>Qoryooley Brothers School</h2>
              <small>Student ID Card - Back</small>
            </div>
            <div class="contact-info">
              <p><strong>Address:</strong> Hodan District, Mogadishu</p>
              <p><strong>Phone:</strong> +252 61 999 1234</p>
              <p><strong>Email:</strong> info@qoryooleyschool.so</p>
            </div>
            <div class="qr-section">
              <canvas id="qrcode-${index}"></canvas>
            </div>
            <div class="footer-note">
              <small>If found, please return to the school office.</small>
            </div>
          </div>
        </div>`;

      cardContainer.innerHTML += front + back;

      // Generate QR Code
      setTimeout(() => {
        new QRious({
          element: document.getElementById(`qrcode-${index}`),
          value: qrValue,
          size: 80
        });
      }, 100);
    });
  }

  // Event Listeners
  classFilter.addEventListener("change", applyFilters);
  searchInput.addEventListener("input", applyFilters);

  // Initial load
  loadClassOptions();
  loadStudents();
});
