<?php
use App\Models\Utils;
?><div class="mx-0 mx-md-5 bg-white p-3 p-md-5">
    <div class="d-md-flex justify-content-between">
        <div>
            <h2 class="m-0 p-0 text-dark h3 text-uppercase"><b><?php echo e($p->name ?? '-', false); ?>'s profile</b></h2>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?php echo e($back_link, false); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> BACK
                TO ALL MEMBERS</a>
            <a href="mailto:<?php echo e($p->email, false); ?>" class="btn btn-warning btn-sm"><i class="fa fa-phone"></i>
                CALL</a>
            <a href="mailto:<?php echo e($p->email, false); ?>" class="btn btn-primary btn-sm"><i class="fa fa-envelope"></i> SEND
                EMAIL</a>
        </div>
    </div>

    <hr class="my-3 my-md-4">

    <div class="row">
        <div class="col-3 col-md-2">
            <div class="border border-1 rounded bg-">
                <img class="img-fluid" src="<?php echo e(url('storage/' . $p->avatar), false); ?>">
            </div>
        </div>

        <div class="col-9 col-md-5">
            <h3 class="text-uppercase h4 p-0 m-0"><b>BIO DATA</b></h3>
            <hr class="my-1 my-md-3">

            <?php echo $__env->make('components.detail-item', [
                't' => 'name',
                's' => $p->name,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Gender',
                's' => $p->sex,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Dob',
                's' => Utils::my_date($p->dob),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


            <?php echo $__env->make('components.detail-item', [
                't' => 'Nationality',
                's' => $p->country,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Current address',
                's' => $p->address,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Fluent language',
                's' => $p->language,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Current occupation',
                's' => $p->occupation,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Email address',
                's' => $p->email,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('components.detail-item', [
                't' => 'Phone number',
                's' => $p->phone_number,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="pt-3 pt-md-0 col-md-5">
            <div class=" border border-primary p-3">
                <h3 class="text-uppercase h4 p-0 m-0 text-center"><b>Summary</b></h3>
                <hr class="border-primary mt-3">
                <div style=" font-size: 16px;">
                    <p class="py-0 my-0  "><b>Name:</b> <?php echo e($p->name, false); ?></p>
                    <p class="py-0 my-0 mt-1"><b>Age:</b> <?php echo e($p->dob, false); ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Sex:</b> <?php echo e($p->sex, false); ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Nationality:</b> <?php echo e($p->country, false); ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Email:</b> <?php echo e($p->email, false); ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Phone number:</b> <?php echo e($p->phone_number, false); ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Whatsapp number:</b> <?php echo $p->whatsapp ?? '-'; ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Facebook username:</b> <?php echo $p->facebook ?? '-'; ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Twitter:</b> <?php echo $p->facebook ?? '-'; ?></p>
                    <p class="py-0 my-0 mt-1"><b>Linkedin:</b> <?php echo $p->linkedin ?? '-'; ?></p>
                    <p class="py-0 my-0 mt-1 "><b>Website:</b> <?php echo $p->website ?? '-'; ?></p>
                </div>
            </div>
        </div>
    </div>

    <hr class="mt-4 mb-2 border-primary pb-0 mt-md-5 mb-md-5">
    <h3 class="text-uppercase h4 p-0 m-0 text-center"><b>About <?php echo e($p->name, false); ?></b></h3>
    <hr class="m-0 pt-2">
    <?php if($p->about != null && strlen($p->about > 10)): ?>
        <?php echo $p->about; ?>

    <?php else: ?>
        <div class="alert alert-secondary mt-2 mt-md-3">
            <p><?php echo e($p->name, false); ?> has not written anything about <?php if($p->sex == 'Male'): ?>
                    himself
                <?php elseif($p->sex == 'Female'): ?>
                    herself
                <?php endif; ?>.
            </p>
        </div>
    <?php endif; ?>



    <hr class="mt-4 mb-2 border-primary pb-0 mt-md-5 mb-md-5 ">
    <h3 class="text-uppercase h4  m-0 text-center mt-2 "><b>Programs accomplished</b></h3>

    <div class="row mt-2">
        <div class="col-12">
            <table class="table table-striped table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col">Award</th>
                        <th scope="col">Program</th>
                        <th scope="col">Year of admission</th>
                        <th scope="col">ICT for persons with disabilites Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $p->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($sus->program_award ?? '-', false); ?></td>
                            <td><?php echo e($sus->program_name ?? '-', false); ?></td>
                            <td><?php echo e($sus->program_year ?? '-', false); ?></td>
                            <td><?php echo e($sus->campus->name ?? '-', false); ?></td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/resources/views/admin/user-prifile.blade.php ENDPATH**/ ?>