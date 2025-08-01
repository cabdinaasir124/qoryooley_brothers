<!DOCTYPE html>
<html lang="so">
<head>
  <meta charset="UTF-8">
  <title>Shahaado Ka-bixid</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background-color: var(--bs-body-bg);
      color: var(--bs-body-color);
    }

    .form-section {
      background-color: var(--bs-light);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    #certificatePreview {
      padding: 40px;
      background-color: white;
      min-height: 1000px;
      position: relative;
      color: black;
    }

    #certFooter {
      display: flex;
      justify-content: space-between;
      position: absolute;
      bottom: 25mm;
      left: 25mm;
      right: 25mm;
    }

    @media print {
      body {
        background: white;
        margin: 0;
      }

      body * {
        visibility: hidden;
      }

      #certificatePreview, #certificatePreview * {
        visibility: visible;
      }

      #certificatePreview {
        position: absolute;
        top: 0;
        left: 0;
        width: 210mm;
        height: 297mm;
        padding: 25mm;
        background: white;
        box-sizing: border-box;
        font-size: 18px;
      }

      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<div class="content-page">
  <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
<body class="container py-4">
  <h4 class="text-primary mb-3 no-print">Shahaado Ka-bixid Arday</h4>

  <div class="form-section mb-4 no-print">
    <form id="leaveCertForm">
      <div class="mb-3">
        <label>Dooro Ardayga</label>
        <select id="studentSelect" class="form-select" required></select>
      </div>

      <div class="mb-3">
        <label>Magaca Ardayga</label>
        <input type="text" id="studentName" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label>Lambarka Ardayga</label>
        <input type="text" id="studentId" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label>Fasalka</label>
        <input type="text" id="className" class="form-control" readonly>
      </div>

      <div class="mb-3">
        <label>Taariikhda Ka-bixitaanka</label>
        <input type="date" id="leavingDate" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Sababta Ka-bixitaanka</label>
        <textarea id="reason" class="form-control" rows="3" required></textarea>
      </div>

      <button type="button" onclick="generateCertificate()" class="btn btn-success w-100">Samee Shahaado</button>
    </form>
  </div>

  <div class="certificate-section">
    <div id="certificatePreview">
      <div class="text-center mb-4">
        <img src="../assets/images/logo.jpg" alt="School Logo" style="height: 150px;">
        <h2 class="fw-bold">Dugsiga Qoryooley Brothers and Sisters</h2>
        <h4 class="text-decoration-underline">Shahaadada Ka-bixitaanka</h4>
        <p><small>Qoryooley, Soomaaliya | Tel: +252 61 9951562</small></p>
        <hr>
      </div>

      <p>Waxaa lagu shahaadinayaa in ardayga <strong><span id="certName">__________</span></strong>,
        oo wata aqoonsiga ardayga <strong><span id="certId">__________</span></strong>,
        uu ahaa arday sax ah oo fasalka <strong><span id="certClass">__________</span></strong> ka tirsan dugsigan.</p>

      <p>Waxa uu/ay si rasmi ah uga baxay dugsiga maalinta <strong><span id="certDate">__________</span></strong>.</p>

      <p>Sababta bixitaanka waa:
        <em><span id="certReason">_________________________</span></em>.</p>

      <p>Lambarka tixraaca: <strong><span id="referenceNumber">---</span></strong></p>

      <p class="mt-5">Waxaan u rajeyneynaa ardayga guul iyo barwaaqo mustaqbalkiisa.</p>

      <div id="certFooter">
        <div>
          <p>_________________________<br><strong>Maamulaha Guud</strong></p>
        </div>
        <div style="text-align: right;">
          <p>Taariikh: <span id="certGeneratedDate"></span></p>
          <canvas id="qrCode" style="height: 80px;"></canvas>
          <p class="text-muted small">Sawir QR si aad u xaqiijiso</p>
        </div>
      </div>
    </div>
    <button class="btn btn-primary mt-3 w-100 no-print" onclick="window.print()"><i class="fas fa-print"></i> Daabac Shahaadada</button>
  </div>
  </div>
  </div>
  </div>
</body>

</html>
