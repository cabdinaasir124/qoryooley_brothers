<div class="content-page">
  <div class="content">
    <div class="container-fluid">

      <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
          <h4>Expense Manager</h4>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseModal">
            <i class="fas fa-plus"></i> Add Expense
          </button>
        </div>
      </div>

 <!-- Summary: Income, Expenses, Balance -->
<div class="row mb-3">
  <div class="col-md-4">
    <div class="card border-success shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-success">Total Income</h5>
        <h4 class="text-success" id="totalIncome">$0</h4>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-danger shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-danger">Total Expenses</h5>
        <h4 class="text-danger" id="totalExpenses">$0</h4>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-info shadow-sm">
      <div class="card-body text-center">
        <h5 class="text-info">Balance</h5>
        <h4 class="text-info" id="currentBalance">$0</h4>
      </div>
    </div>
  </div>
</div>

      <!-- Filters & Export -->
      <div class="row mb-3 align-items-center">
        <div class="col-md-4">
          <select id="filterCategory" class="form-select">
            <option value="">All Categories</option>
            <option value="Income">Income</option>
            <option value="Food">Food</option>
            <option value="Transport">Transport</option>
            <option value="Utilities">Utilities</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="col-md-8 text-end">
          <button id="exportExcelBtn" class="btn btn-outline-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
          </button>
          <button id="exportPdfBtn" class="btn btn-outline-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
          </button>
        </div>
      </div>

      <!-- Expense Table -->
      <div class="table-responsive">
      <table id="expenseTable" class="table table-hover table-bordered shadow-sm rounded">
  <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Category</th>
      <th>Amount</th>
      <th>Date</th>
      <th>Description</th>
      <th>Actions</th> <!-- This will be excluded in PDF/Excel -->
    </tr>
  </thead>
  <tbody></tbody>
</table>

      </div>

      <!-- Chart -->
      <div class="row mt-4">
        <div class="col-md-12">
          <canvas id="expenseChart" height="100"></canvas>
        </div>
      </div>

      <!-- Expense Modal -->
      <div class="modal fade" id="expenseModal" tabindex="-1">
        <div class="modal-dialog">
          <form id="expenseForm" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add/Edit Expense</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="expense_id">

              <div class="mb-2">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>

              <div class="mb-2">
                <label>Category</label>
                <select name="category" class="form-select" required>
                  <option value="Income">Income</option>
                  <option value="Food">Food</option>
                  <option value="Transport">Transport</option>
                  <option value="Utilities">Utilities</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="mb-2">
                <label>Amount ($)</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
              </div>

              <div class="mb-2">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required>
              </div>

              <div class="mb-2">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
