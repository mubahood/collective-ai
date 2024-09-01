<div class="card mb-4 mb-md-5 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margin: 0;" class="fs-22 fw-800">
            Groundnut Production on market over time
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <canvas id="barGraph" style="width: 100%;"></canvas>
    </div>
</div>

<script>
    $(function () {
        // Define data for different groundnut varieties and their production over time
        var varieties = ['Valencia', 'Virginia', 'Spanish'];
        var productionData = {
            labels: ['2020', '2021', '2022', '2023'],
            datasets: varieties.map(function (variety, index) {
                return {
                    label: variety,
                    backgroundColor: getBackgroundColor(index),
                    data: [10, 15, 20, 18], // Update production data for each variety
                };
            }),
        };

        var config = {
            type: 'bar',
            data: productionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                },
            },
        };

        var ctx = document.getElementById('barGraph').getContext('2d');
        new Chart(ctx, config);
    });

    // Function to generate background colors for the datasets
    function getBackgroundColor(index) {
        var colors = ['#FF5733', '#33FF57', '#5733FF']; // Color options
        return colors[index];
    }
</script>
