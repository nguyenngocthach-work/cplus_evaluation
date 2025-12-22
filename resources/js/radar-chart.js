function renderRadarChart(labels, scores) {
    const ctx = document.getElementById('radarChart');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                data: scores,
                backgroundColor: 'rgba(13,110,253,0.2)',
                borderColor: '#0d6efd'
            }]
        },
        options: {
            scales: {
                r: { min: 0, max: 10 }
            }
        }
    });
}
