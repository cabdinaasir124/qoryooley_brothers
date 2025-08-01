
  // Load student dropdown
  fetch("../api/student2_api.php?action=all")
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("studentSelect");
      data.forEach(student => {
        const option = document.createElement("option");
        option.value = student.id;
        option.textContent = `${student.full_name} (${student.class_name})`;
        select.appendChild(option);
      });
    });

  // Autofill form fields
  document.getElementById("studentSelect").addEventListener("change", function () {
    const id = this.value;
    if (!id) return;
    fetch(`../api/student2_api.php?action=details&id=${id}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById("studentName").value = data.full_name;
        document.getElementById("studentId").value = data.student_id;
        document.getElementById("className").value = data.class_name;
      });
  });

  // Generate certificate
  function generateCertificate() {
    const name = document.getElementById("studentName").value;
    const sid = document.getElementById("studentId").value;
    const cls = document.getElementById("className").value;
    const date = new Date(document.getElementById("leavingDate").value).toDateString();
    const reason = document.getElementById("reason").value;
    const ref = 'REF-' + Date.now();

    document.getElementById("certName").textContent = name;
    document.getElementById("certId").textContent = sid;
    document.getElementById("certClass").textContent = cls;
    document.getElementById("certDate").textContent = date;
    document.getElementById("certReason").textContent = reason;
    document.getElementById("referenceNumber").textContent = ref;
    document.getElementById("certGeneratedDate").textContent = new Date().toDateString();

    new QRious({
      element: document.getElementById("qrCode"),
      value: `https://naasir.xirfadeeye.com/verify-certificate.php?ref=${ref}`,
      size: 100
    });
  }
