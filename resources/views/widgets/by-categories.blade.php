<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card  mb-4 mb-md-5 border-0" style="color: black;">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margrin: 0; " class="fs-22 fw-800">
            Gardens by Varieties
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <div style="width: 80%; margin: auto;">
            <canvas id="gardens-by-varieties"></canvas>
        </div>
        {{-- view all --}}
        <a href="{{ admin_url('gardens') }}" class="btn btn-primary btn-sm mt-3">View all gardens</a>
    </div>
</div>




<script>
    // Sample data for pest and disease severity in different areas of the farm


    new Chart(document.getElementById('gardens-by-varieties').getContext('2d'), {
        type: 'pie',
        data: {
            labels: JSON.parse('<?php echo json_encode($lables); ?>'),
            datasets: [{
                label: 'Pests & Diseases',
                data: {{ json_encode($counts) }},
                backgroundColor: [
                    'rgba(0, 0, 255, 0.7)',
                    'rgba(255, 69, 0, 0.7)',
                    'rgba(255, 102, 0, 0.7)',
                    'rgba(218, 112, 214, 0.7)',
                    'rgba(0, 128, 128, 0.7)',
                    'rgba(0, 255, 0, 0.7)',
                    'rgba(65, 105, 225, 0.7)',
                    'rgba(255, 0, 0, 0.7)',
                    'rgba(255, 255, 0, 0.7)',
                ],
            }]
        },
    });
</script>
