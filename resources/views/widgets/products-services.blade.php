<div class="card mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margin: 0;" class="fs-22 fw-800">
            Market Comparison: Products vs Services
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <canvas id="lineGraph" style="width: 100%;"></canvas>
    </div>
</div>

<script>
    $(function () {
        var years = ['2020', '2021', '2022', '2023'];
        var productData = [150, 180, 200, 220]; // Product data over the years
        var serviceData = [100, 120, 130, 140]; // Service data over the years

        var config = {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Products',
                    borderColor: '#007BFF',
                    backgroundColor: '#007BFF',
                    data: productData,
                    fill: false,
                }, {
                    label: 'Services',
                    borderColor: '#FF5733',
                    backgroundColor: '#FF5733',
                    data: serviceData,
                    fill: false,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Year',
                        },
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Revenue',
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            },
        };

        var ctx = document.getElementById('lineGraph').getContext('2d');
        new Chart(ctx, config);
    });
</script>
