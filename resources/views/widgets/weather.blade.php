<div class="card mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margin: 0;" class="fs-22 fw-800">
            Weather Data Visualization
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <!-- Move the canvas element inside the card -->
        <canvas id="weatherChart" style="width: 100%;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample weather data (temperature, precipitation, humidity) over time
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const temperatureData = [10, 12, 15, 18, 22, 25];
    const precipitationData = [30, 40, 20, 15, 10, 5];
    const humidityData = [60, 58, 55, 52, 50, 48];

    const ctx = document.getElementById('weatherChart').getContext('2d');

    const weatherChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (°C)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: temperatureData,
                },
                {
                    label: 'Precipitation (mm)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: precipitationData,
                },
                {
                    label: 'Humidity (%)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: humidityData,
                }
            ]
        },
        options: {
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
