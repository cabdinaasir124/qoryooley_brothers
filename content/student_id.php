<!-- BEGIN ID CARD DESIGN -->
<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <div class="filters p-3" style="text-align:left; margin-bottom: 10px;">
        <label for="classFilter">Filter by Class: </label><br>
       <select id="classFilter" class="form-select w-100">
    <option value="">All Classes</option>
    <?php
      $classList = mysqli_query($conn, "SELECT id, class_name FROM classes ORDER BY class_name ASC");
      while ($c = mysqli_fetch_assoc($classList)) {
          echo "<option value='{$c['class_name']}'>{$c['class_name']}</option>";
      }
    ?>
  </select>
        <input type="text" id="searchInput" placeholder="Search by Name, ID, or Class" style="margin-top:10px; padding:5px; width: 200px;">
<div id="pagination" class="pagination" style="margin-top:20px;"></div>

      </div>

    <div id="noDataMessage" style="display: none; text-align: center; color: red; font-weight: bold; margin-bottom: 20px;">
  No student found.
</div>
<div class="scroll-wrapper p-3">
  <div class="id-card-container" id="cardContainer">
    <!-- ID cards will be injected here -->
  </div>
</div>



      <div class="print-btn mb-3" style="text-align:center; margin-top: 20px;">
        <button onclick="window.print()" style="padding:10px 20px; background:#003366; color:#fff; border:none; border-radius:6px; font-size:16px; cursor:pointer;">Print ID Card</button>
      </div>

    </div>
  </div>
</div>

<!-- CSS STYLES -->
<style>
.scroll-wrapper {
  max-height: 80vh; /* or adjust to your layout */
  overflow-y: auto;
  padding-right: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  margin-bottom: 20px;
}

.scroll-wrapper::-webkit-scrollbar {
  width: 8px;
}

.scroll-wrapper::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.scroll-wrapper::-webkit-scrollbar-thumb {
  background: #003366;
  border-radius: 4px;
}

.scroll-wrapper::-webkit-scrollbar-thumb:hover {
  background: #0066cc;
}


  .id-card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    font-family: 'Segoe UI', sans-serif;
  }

  .id-card-page {
    page-break-after: always;
  }

  .id-card {
    width: 320px;
    height: 430px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px;
  }

  .id-card.front {
    background: #f4faff;
  }

  .id-card.back {
    background: #f9f9f9;
    text-align: center;
    padding-top: 30px;
  }

  .header {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .school-logo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }

  .school-info h2 {
    font-size: 18px;
    margin: 0;
    color: #003366;
  }

  .photo-section {
    text-align: center;
    margin-top: 15px;
  }

  .student-photo {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 3px solid #003366;
    object-fit: cover;
  }

  .info-table {
    width: 100%;
    margin-top: 15px;
    font-size: 14px;
    border-collapse: collapse;
  }

  .info-table th {
    text-align: left;
    padding: 4px;
    width: 40%;
    color: #333;
  }

  .info-table td {
    padding: 4px;
    color: #003366;
    font-weight: bold;
  }

  .contact-info {
    margin: 20px 10px;
    font-size: 14px;
    color: #444;
  }

  .qr-section {
    margin: 10px auto;
  }

  .footer-note {
    text-align: center;
    font-size: 11px;
    color: #777;
    margin-top: auto;
  }

  @media print {
    .filters, .print-btn {
      display: none;
    }
    body {
      background: white;
    }
    .id-card-page {
      page-break-after: always;
    }
  }
</style>


