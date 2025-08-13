// 📁 File: assets/js/expense_manager.js
$(document).ready(function () {
  let table;
  let expenseChart;

  // Initialize DataTable
  function initializeDataTable() {
    table = $('#expenseTable').DataTable({
      responsive: true,
      destroy: true,
      data: [],
      columns: [
        { title: '#' },
        { title: 'Title' },
        { title: 'Description' },
        { title: 'Amount' },
        { title: 'Date' },
        { title: 'Category' },
        { title: 'Actions' }
      ]
    });
  }

  // Load totals
  function loadTotals() {
    $.getJSON('../api/expenses_api.php?action=totals', function (res) {
      $('#totalIncome').text(`$${res.income.toFixed(2)}`);
      $('#totalExpenses').text(`$${res.expenses.toFixed(2)}`);
      $('#currentBalance').text(`$${res.balance.toFixed(2)}`);
    });
  }

  // Fetch expenses
  function fetchExpenses(filterCategory = '') {
    $.getJSON('../api/expenses_api.php?action=fetch', function (data) {
      table.clear();

      const filtered = filterCategory
        ? data.filter(item => item.category === filterCategory)
        : data;

      filtered.forEach((row, i) => {
        const amount = parseFloat(row.amount);
        table.row.add([
          i + 1,
          row.title,
          row.description || '-',
          `$${amount.toFixed(2)}`,
          row.date,
          row.category,
          `
            <button class="btn btn-sm btn-warning expense-edit-btn" data-id="${row.expense_id}">Edit</button>
            <button class="btn btn-sm btn-danger expense-delete-btn" data-id="${row.expense_id}">Delete</button>
          `
        ]);
      });

      table.draw();
      loadTotals();
      drawChart(filtered);
    });
  }

  // Draw category chart
  function drawChart(data) {
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const totals = {};

    data.forEach(item => {
      totals[item.category] = (totals[item.category] || 0) + parseFloat(item.amount);
    });

    const labels = Object.keys(totals);
    const values = Object.values(totals);

    if (expenseChart) expenseChart.destroy();

    expenseChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Amount by Category',
          data: values,
          backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1']
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }

  // Handle form submission
  $('#expenseForm').submit(function (e) {
    e.preventDefault();

    const category = $('[name="category"]').val();
    const amount = parseFloat($('[name="amount"]').val());
    const income = parseFloat($('#totalIncome').text().replace('$', ''));
    const expenses = parseFloat($('#totalExpenses').text().replace('$', ''));
    const currentBalance = income - expenses;

    if (income === 0 && category !== 'Income') {
      Swal.fire({ icon: 'warning', title: 'No Income', text: 'Add income before expenses.' });
      return;
    }

    if (category !== 'Income' && amount > currentBalance) {
      Swal.fire({ icon: 'error', title: 'Insufficient Balance', text: 'Expense exceeds current balance.' });
      return;
    }

    const formData = $(this).serialize();
    const action = $('#expense_id').val() === '' ? 'create' : 'update';

    $.post(`../api/expenses_api.php?action=${action}`, formData, function (res) {
      if (res.status === 'success' || res.status === 'updated') {
        $('#expenseModal').modal('hide');
        $('#expenseForm')[0].reset();
        fetchExpenses($('#filterCategory').val());
        Swal.fire({ icon: 'success', title: 'Saved', text: 'Expense saved successfully!' });
      } else if (res.status === 'no_change') {
        Swal.fire({ icon: 'info', title: 'No Changes', text: 'No changes were made.' });
      } else {
        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Error saving expense' });
      }
    }, 'json');
  });

  // Edit expense
$(document).on('click', '.expense-edit-btn', function () {
  const id = $(this).data('id');
  $.getJSON(`../api/expenses_api.php?action=get&id=${id}`, function (data) {
    $('#expense_id').val(data.expense_id); // ✅ critical for update
    $('[name="title"]').val(data.title);
    $('[name="category"]').val(data.category);
    $('[name="amount"]').val(data.amount);
    $('[name="date"]').val(data.date);
    $('[name="description"]').val(data.description);
    $('#expenseModal').modal('show');
  });
});


  // Delete expense
  $(document).on('click', '.expense-delete-btn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This expense will be permanently deleted!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('../api/expenses_api.php?action=delete', { id }, function (res) {
          if (res.status === 'deleted') {
            fetchExpenses($('#filterCategory').val());
            Swal.fire('Deleted!', 'Expense deleted successfully.', 'success');
          } else {
            Swal.fire('Error', 'Failed to delete expense.', 'error');
          }
        }, 'json');
      }
    });
  });

  // Filter
  $('#filterCategory').change(function () {
    fetchExpenses($(this).val());
  });

  // Init
  initializeDataTable();
  fetchExpenses();
});
