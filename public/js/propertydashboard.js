document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('rentalbilledcollectionschart').getContext('2d');

    const rentalbilledcollectionschart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: window.rentalChartData.labels,
            datasets: [
                {
                    label: 'Collections',
                    data: window.rentalChartData.rentalcollected,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                },
                {
                    label: 'Invoices',
                    data: window.rentalChartData.rentalbilled,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
