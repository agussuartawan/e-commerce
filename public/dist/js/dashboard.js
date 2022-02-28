$(function () {
    $(document).ready(function () {
        var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
        var salesChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [
              {
                label: 'Jumlah Pesanan',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: true,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [100, 200, 300, 100, 50, 500, 700, 300, 1000, 900, 500, 0]
              },
            ]
          }
        
          var salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
              display: true
            },
            scales: {
              xAxes: [{
                gridLines: {
                  display: true
                }
              }],
              yAxes: [{
                gridLines: {
                  display: true
                }
              }]
            }
          }
        
          // This will get the first returned node in the jQuery collection.
          // eslint-disable-next-line no-unused-vars
          var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
          })
    });
});