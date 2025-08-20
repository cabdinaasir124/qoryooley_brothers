$(document).ready(function () {
    fetchRecords();

    // ✅ Fetch records
    function fetchRecords() {
        $.ajax({
            url: "../api/tajweed_api.php",
            type: "POST",
            data: { action: "fetch" },
            dataType: "json",
            success: function (data) {
                let tbody = "";
                data.forEach((row, i) => {
                    tbody += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${row.student_name}</td>
                            <td>${row.lesson}</td>
                            <td>${row.date}</td>
                            <td>${row.remarks}</td>
                            <td>
                                <button data-bs-target="#tajweedUpdateModal" data-bs-toggle="modal"  class="btn btn-sm btn-warning editBtn" data-id="${row.id}">Edit</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $("#tajweedBody").html(tbody);
            }
        });
    }

    // ✅ Add new record
    $("#addNewBtn").click(function () {
        $("#tajweedForm")[0].reset();
        $("#recordId").val("");
        $("#tajweedModal").modal("show");
    });

    // ✅ Submit form (Create/Update)
    $("#tajweedForm").submit(function (e) {
        e.preventDefault();
        let id = $("#recordId").val();
        let action = id ? "update" : "create";

        $.ajax({
            url: "../api/tajweed_api.php",
            type: "POST",
            data: $(this).serialize() + "&action=" + action,
            dataType: "json",
            success: function (res) {
                
             Toastify({ text: res.message, backgroundColor: "green", duration: 3000 }).showToast();

                $("#tajweedModal").modal("hide");
                $("#tajweedForm")[0].reset();
                fetchRecords();
            }
        });
    });

// ✅ Edit record (open modal with values)
$(document).on("click", ".editBtn", function () {
   let id = $(this).attr("data-id");

   $.ajax({
        type: "POST",
        url: "../api/tajweed_api.php",
        data: { action: "edit_tajweed", id: id },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                var data = response.row;

       $("#TajweedUpdateModalBody").html(`
   <form id="tajweedUpdateForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Tajweed Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value='${data.id}'>
          <div class="mb-3">
            <label>Student Name</label>
            <input type="text" class="form-control" value='${data.student_name}' name="student_name" required>
          </div>
          <div class="mb-3">
            <label>Lesson</label>
            <input type="text" class="form-control" value='${data.lesson}' name="lesson" required>
          </div>
          <div class="mb-3">
            <label>Date</label>
            <input type="date" class="form-control" value='${data.date}' name="date" required>
          </div>
          <div class="mb-3">
            <label>Remarks</label>
            <textarea class="form-control" name="remarks">${data.remarks}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
`);



                $("#tajweedUpdateModal").modal("show"); 
            } else {
                alert(response.message);
            }
        }
   });
});


// ✅ Update record form submit
$(document).on("submit", "#tajweedUpdateForm", function (e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "../api/tajweed_api.php",
        data: $(this).serialize() + "&action=update",
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                Toastify({ text: response.message, backgroundColor: "green", duration: 3000 }).showToast();
                $("#tajweedUpdateModal").modal("hide");
                $("#tajweedUpdateForm")[0].reset();
                fetchRecords();

            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            alert("Error occurred while updating record");
        }
    });
});



    // ✅ Delete record
    $(document).on("click", ".deleteBtn", function () {
        if (!confirm("Are you sure to delete this record?")) return;
        let id = $(this).data("id");

        $.ajax({
            url: "../api/tajweed_api.php",
            type: "POST",
            data: { action: "delete", id: id },
            dataType: "json",
            success: function (res) {
            Toastify({ text: res.message, backgroundColor: "green", duration: 3000 }).showToast();

                fetchRecords();
            }
        });
    });
});
