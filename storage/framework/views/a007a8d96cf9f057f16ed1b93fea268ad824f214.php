<?php $__currentLoopData = $css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link rel="stylesheet" href="<?php echo e(admin_asset("$c"), false); ?>">
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php

$primt_color = '#23A454';
?><style> 
    .sidebar {
        background-color: #FFFFFF;
    }

    .content-header {
        background-color: #F9F9F9;
    }

    .sidebar-menu .active {
        border-left: solid 5px <?php echo e($primt_color, false); ?> !important;
        ;
        color: <?php echo e($primt_color, false); ?> !important;
        ;
    }


    .navbar,
    .logo,
    .sidebar-toggle,
    .user-header,
    .btn-dropbox,
    .btn-twitter,
    .btn-instagram,
    .btn-primary,
    .navbar-static-top {
        background-color: <?php echo e($primt_color, false); ?> !important;
    }

    .dropdown-menu {
        border: none !important;
    }

    .box-success {
        border-top: <?php echo e($primt_color, false); ?> .5rem solid !important;
    }

    :root {
        --primary: <?php echo e($primt_color, false); ?>;
    }
    .card {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }
</style> 
<?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/vendor/encore/laravel-admin/src/../resources/views/partials/css.blade.php ENDPATH**/ ?>