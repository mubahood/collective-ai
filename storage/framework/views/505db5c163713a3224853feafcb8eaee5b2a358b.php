<a class="card  mb-4 mb-md-5 border-0" href="<?php echo e(admin_url('pests-and-diseases'), false); ?>" title="View all reports"
    style="color: black;">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 pt-2 px-md-4 border-bottom">
        <h4 style="line-height: 1; margrin: 0; " class="fs-22 fw-800">
            Recently reported pest & diseases
        </h4>
    </div>
    <div class="card-body py-2 py-md-3">
        <?php if(count($data) == 0): ?>
            <div class="text-center">
                <h5 class="text-dark">No pests & diseases reported yet.</h5>
                <hr>
                <p>Open the app and report any pests & diseases you see</p>
            </div>
        <?php else: ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row  pl-4 mt-3" style="line-height:16px;">
                    <img src="<?php echo e(url('storage/' . $item->photo), false); ?>" width="50" height="50" class="rounded mr-3"
                        alt="">
                    <p>
                        <strong><?php echo e($item->name, false); ?></strong>
                        <?php if($item->user != null): ?>
                            <br>
                            <small>Reported by: <?php echo e($item->user->name, false); ?></small>
                        <?php endif; ?>
                        <small class="d-block text-primary"><?php echo e($item->created_at->diffForHumans(), false); ?></small>
                    </p>
                </div>
                <hr style="margin: 0; ">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</a>
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/resources/views/widgets/pests-2.blade.php ENDPATH**/ ?>