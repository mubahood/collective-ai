

<span class="ie-wrap">
    <a
        href="javascript:void(0);"
        class="<?php echo e($trigger, false); ?>"
        data-toggle="popover"
        data-target="<?php echo e($target, false); ?>"
        data-value="<?php echo e($value, false); ?>"
        data-original="<?php echo e($value, false); ?>"
        data-key="<?php echo e($key, false); ?>"
        data-name="<?php echo e($name, false); ?>"
    >
        <span class="ie-display"><?php echo e($display, false); ?></span>

        <i class="fa fa-edit" style="visibility: hidden;"></i>
    </a>
</span>

<template>
    <template id="<?php echo e($target, false); ?>">
        <div class="ie-content ie-content-<?php echo e($name, false); ?>">
            <div class="ie-container">
                <?php echo $__env->yieldContent('field'); ?>
                <div class="error"></div>
            </div>
            <div class="ie-action">
                <button class="btn btn-primary btn-sm ie-submit"><?php echo e(__('admin.submit'), false); ?></button>
                <button class="btn btn-default btn-sm ie-cancel"><?php echo e(__('admin.cancel'), false); ?></button>
            </div>
        </div>
    </template>
</template>

<style>
    .ie-wrap>a {
        padding: 3px;
        border-radius: 3px;
        color:#777;
    }

    .ie-wrap>a:hover {
        text-decoration: none;
        background-color: #ddd;
        color:#777;
    }

    .ie-wrap>a:hover i {
        visibility: visible !important;
    }

    .ie-action button {
        margin: 10px 0 10px 10px;
        float: right;
    }

    .ie-container  {
        width: 250px;
        position: relative;
    }

    .ie-container .error {
        color: #dd4b39;
        font-weight: 700;
    }
</style>

<script>
    $(document).on('click', '.ie-action .ie-cancel', function () {
        $('[data-toggle="popover"]').popover('hide');
    });

    $('body').on('click', function (e) {
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('[data-toggle="popover"]').length === 0
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });
</script>

<?php echo $__env->yieldContent('assert'); ?>
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/vendor/encore/laravel-admin/src/../resources/views/grid/inline-edit/comm.blade.php ENDPATH**/ ?>