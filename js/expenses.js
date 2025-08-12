// 📁 File: assets/js/expense_manager.js

$(document).ready(function () {
  let table;
  let expenseChart;

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

  function updateTotals() {
    $.getJSON('../api/expenses_api.php?action=totals', function (totals) {
      $('#totalIncome').text(`$${totals.income.toFixed(2)}`);
      $('#totalExpenses').text(`$${totals.expenses.toFixed(2)}`);
      $('#currentBalance').text(`$${totals.balance.toFixed(2)}`);

      if (totals.income <= 0 && totals.expenses > 0) {
        $('#incomeNote')
          .text('N.B: Please add income before recording expenses.')
          .fadeIn();
      } else {
        $('#incomeNote').fadeOut();
      }
    });
  }

  function fetchExpenses(filterCategory = '') {
  $.getJSON('../api/expenses_api.php?action=fetch', function (data) {
    table.clear();

    let filtered = filterCategory
      ? data.filter(item => item.category === filterCategory)
      : data;

    filtered.forEach((row, i) => {
      const amount = parseFloat(row.amount);
      table.row.add([
        i + 1,
        row.title,
        row.description || '-',
        '$' + amount.toFixed(2),
        row.date,
        row.category,
        `
        <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}">Edit</button>
        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
        `
      ]);
    });

    table.draw();

    // ✅ Recalculate totals from backend
    $.getJSON('../api/expenses_api.php?action=totals', function (totals) {
      const { income, expenses, balance } = totals;

      $('#totalIncome').text(`$${income.toFixed(2)}`);
      $('#totalExpenses').text(`$${expenses.toFixed(2)}`);
      $('#currentBalance').text(`$${balance.toFixed(2)}`);

      if (income <= 0 && expenses > 0) {
        $('#incomeNote')
          .text('N.B: Please add income before recording expenses.')
          .fadeIn();
      } else {
        $('#incomeNote').fadeOut();
      }
    });

    // ✅ Refresh chart only with filtered
    drawChart(filtered);
  });
}


  function loadTotals() {
  $.getJSON('../api/expenses_api.php?action=totals', function (res) {
    $('#totalIncome').text(`$${res.income.toFixed(2)}`);
    $('#totalExpenses').text(`$${res.expenses.toFixed(2)}`);
    $('#currentBalance').text(`$${res.balance.toFixed(2)}`);
  });
}
  loadTotals();


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
        labels: labels,
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

  $('#expenseForm').submit(function (e) {
    e.preventDefault();

    const category = $('[name="category"]').val();
    const amount = parseFloat($('[name="amount"]').val());
    const income = parseFloat($('#totalIncome').text().replace('$', ''));
    const expenses = parseFloat($('#totalExpenses').text().replace('$', ''));
    const currentBalance = income - expenses;

    if (income === 0 && category !== 'Income') {
      Swal.fire({ icon: 'warning', title: 'No Income', text: 'You must first add income before recording expenses.' });
      return;
    }

    if (category !== 'Income' && amount > currentBalance) {
      Swal.fire({ icon: 'error', title: 'Insufficient Balance', text: 'This expense exceeds your current income.' });
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
      } else {
        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Error saving expense' });
      }
    }, 'json');
  });

  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    $.getJSON(`../api/expenses_api.php?action=get&id=${id}`, function (data) {
      $('#expense_id').val(data.id);
      $('[name="title"]').val(data.title);
      $('[name="category"]').val(data.category);
      $('[name="amount"]').val(data.amount);
      $('[name="date"]').val(data.date);
      $('[name="description"]').val(data.description);
      $('#expenseModal').modal('show');
    });
  });

  $(document).on('click', '.delete-btn', function () {
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

  $('#filterCategory').change(function () {
    const selected = $(this).val();
    fetchExpenses(selected);
  });

  $('#exportExcelBtn').click(function () {
    const tableClone = $('#expenseTable').clone();
    tableClone.find('th:last-child, td:last-child').remove();

    const income = $('#totalIncome').text();
    const expenses = $('#totalExpenses').text();
    const balance = `$${(parseFloat(income.replace('$', '')) - parseFloat(expenses.replace('$', ''))).toFixed(2)}`;

    tableClone.append(`
      <tr><td colspan="3"><strong>Total Income:</strong></td><td colspan="3">${income}</td></tr>
      <tr><td colspan="3"><strong>Total Expenses:</strong></td><td colspan="3">${expenses}</td></tr>
      <tr><td colspan="3"><strong>Balance:</strong></td><td colspan="3">${balance}</td></tr>
    `);

    const ws = XLSX.utils.table_to_sheet(tableClone[0]);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Expenses');
    XLSX.writeFile(wb, 'expenses.xlsx');
  });

  $('#exportPdfBtn').click(function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text('Expense Report', 14, 15);
    const tableEl = $('#expenseTable').clone();
    tableEl.find('th:last-child, td:last-child').remove();

    const income = $('#totalIncome').text();
    const expenses = $('#totalExpenses').text();
    const balance = `$${(parseFloat(income.replace('$', '')) - parseFloat(expenses.replace('$', ''))).toFixed(2)}`;

    tableEl.find('tbody').append(`
      <tr><td colspan="3"><strong>Total Income:</strong></td><td colspan="3">${income}</td></tr>
      <tr><td colspan="3"><strong>Total Expenses:</strong></td><td colspan="3">${expenses}</td></tr>
      <tr><td colspan="3"><strong>Balance:</strong></td><td colspan="3">${balance}</td></tr>
    `);

    doc.autoTable({ html: tableEl[0], startY: 25 });
    doc.save('expenses.pdf');
  });

  initializeDataTable();
  fetchExpenses();
});
