<div class="card  mb-4 mb-md-5 border-0" style="color: black;">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margrin: 0; " class="fs-22 fw-800">
            Pests & diseases by Districts
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <div style="width: 80%; margin: auto;">
            <canvas id="pests-by-district"></canvas>
        </div>
        {{-- view all --}}
        <a href="{{ admin_url('pests-and-diseases') }}" class="btn btn-primary btn-sm mt-3">View all reports</a>
    </div>
</div>




<script>
    // Sample data for pest and disease severity in different areas of the farm


    // Create the bar chart
    const ctx2 = document.getElementById('pests-by-district').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: JSON.parse('<?php echo json_encode($lables); ?>'),
            datasets: [{
                label: 'Pests & Diseases',
                data: {{ json_encode($counts) }},
                backgroundColor: [
                    'rgba(0, 128, 128, 0.7)',
                    'rgba(218, 112, 214, 0.7)',
                    'rgba(255, 69, 0, 0.7)',
                    'rgba(255, 102, 0, 0.7)',
                    'rgba(65, 105, 225, 0.7)',
                    'rgba(255, 0, 0, 0.7)',
                    'rgba(0, 0, 255, 0.7)',
                    'rgba(255, 255, 0, 0.7)',
                    'rgba(0, 255, 0, 0.7)',
                ],
            }]
        },
    });
</script>
