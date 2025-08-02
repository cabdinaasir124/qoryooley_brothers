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

  // Fetch and load expenses (with optional category filter)
  function fetchExpenses(filterCategory = '') {
    $.getJSON('../api/expenses_api.php?action=fetch', function (data) {
      table.clear();

      // Filter if category selected
      let filtered = filterCategory
        ? data.filter(item => item.category === filterCategory)
        : data;

      let totalIncome = 0;
      let totalExpenses = 0;

      filtered.forEach((row, i) => {
        const amount = parseFloat(row.amount);
        if (row.category === 'Income') totalIncome += amount;
        else totalExpenses += amount;

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

      $('#totalIncome').text(`$${totalIncome.toFixed(2)}`);
        $('#totalExpenses').text(`$${totalExpenses.toFixed(2)}`);
        $('#currentBalance').text(`$${(totalIncome - totalExpenses).toFixed(2)}`);
            // Draw chart with filtered data

      drawChart(filtered);
    });
  }

  // Draw Chart.js bar chart by category totals
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

  // Handle form submission for create/update
  $('#expenseForm').submit(function (e) {
  e.preventDefault();

  const category = $('[name="category"]').val();
  const amount = parseFloat($('[name="amount"]').val());

  const income = parseFloat($('#totalIncome').text().replace('$', ''));
  const expenses = parseFloat($('#totalExpenses').text().replace('$', ''));
  const currentBalance = income - expenses;

  // 🚫 Prevent expenses if no income
  if (income === 0 && category !== 'Income') {
    alert("You must first add an income before recording expenses.");
    return;
  }

  // 🚫 Prevent if expense > current balance
  if (category !== 'Income' && amount > currentBalance) {
    alert("Insufficient balance. This expense exceeds your current income.");
    return;
  }

  const formData = $(this).serialize();
  const action = $('#expense_id').val() === '' ? 'create' : 'update';

  $.post(`../api/expenses_api.php?action=${action}`, formData, function (res) {
    if (res.status === 'success' || res.status === 'updated') {
      $('#expenseModal').modal('hide');
      $('#expenseForm')[0].reset();
      fetchExpenses($('#filterCategory').val());
    } else {
      alert(res.message || 'Error saving expense');
    }
  }, 'json');
});


  // Edit button click
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

  // Delete button click
  $(document).on('click', '.delete-btn', function () {
    if (confirm("Delete this expense?")) {
      const id = $(this).data('id');
      $.post('../api/expenses_api.php?action=delete', { id }, function (res) {
        if (res.status === 'deleted') {
          fetchExpenses($('#filterCategory').val());
        } else {
          alert('Error deleting');
        }
      }, 'json');
    }
  });

  // Category filter change
  $('#filterCategory').change(function () {
    const selected = $(this).val();
    fetchExpenses(selected);
  });

  // Export to Excel using SheetJS
  $('#exportExcelBtn').click(function () {
  const tableClone = $('#expenseTable').clone();
  tableClone.find('th:last-child, td:last-child').remove(); // Remove "Actions"

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


  // Export to PDF using jsPDF + autoTable
 $('#exportPdfBtn').click(function () {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  doc.text('Expense Report', 14, 15);

  const tableEl = $('#expenseTable').clone(); // clone to remove actions
  tableEl.find('th:last-child, td:last-child').remove(); // remove "Actions"

  const income = $('#totalIncome').text();
  const expenses = $('#totalExpenses').text();
  const balance = `$${(parseFloat(income.replace('$', '')) - parseFloat(expenses.replace('$', ''))).toFixed(2)}`;

  const finalRow = `
    <tr>
      <td colspan="3"><strong>Total Income:</strong></td>
      <td colspan="3">${income}</td>
    </tr>
    <tr>
      <td colspan="3"><strong>Total Expenses:</strong></td>
      <td colspan="3">${expenses}</td>
    </tr>
    <tr>
      <td colspan="3"><strong>Balance:</strong></td>
      <td colspan="3">${balance}</td>
    </tr>
  `;

  tableEl.find('tbody').append(finalRow);

  doc.autoTable({ html: tableEl[0], startY: 25 });
  doc.save('expenses.pdf');
});


  // Initialize everything
  initializeDataTable();
  fetchExpenses();
});
