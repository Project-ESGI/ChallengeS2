document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('category-filter');
    const tableRows = document.querySelectorAll('.table tbody tr');

    categoryFilter.addEventListener('change', function () {
        const selectedCategory = categoryFilter.value;
        console.log('Sélection de catégorie : ' + selectedCategory);

        tableRows.forEach(function (row) {
            const categoryCell = row.querySelector('td:nth-child(5)');

            if (selectedCategory === 'toutes' || categoryCell.textContent === selectedCategory) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
