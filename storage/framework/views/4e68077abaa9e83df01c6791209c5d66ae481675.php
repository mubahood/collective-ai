<?php $__env->startSection('field'); ?>
    <input class="form-control ie-input"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('assert'); ?>
    <style>
        .ie-content-<?php echo e($name, false); ?> .ie-container  {
            height: 290px;
        }

        .ie-content-<?php echo e($name, false); ?> .ie-input {
            display: none;
        }
    </style>

    <script>
        <?php $__env->startComponent('admin::grid.inline-edit.partials.popover', compact('trigger')); ?>
            <?php $__env->slot('content'); ?>
            $template.find('input').attr('value', $trigger.data('value'));
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('shown'); ?>
            var $input  = $popover.find('.ie-input');

            $popover.find('.ie-container').datetimepicker({
                inline: true,
                format: '<?php echo e($format, false); ?>',
                date: $input.val(),
                locale: '<?php echo e($locale, false); ?>'
            }).on('dp.change', function (event) {
                var date = event.date.format('<?php echo e($format, false); ?>');
                $input.val(date);
            });
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    </script>

    
    <script>
    <?php $__env->startComponent('admin::grid.inline-edit.partials.submit', compact('resource', 'name')); ?>
        $popover.data('display').html(val);
    <?php echo $__env->renderComponent(); ?>
    </script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin::grid.inline-edit.comm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/vendor/encore/laravel-admin/src/../resources/views/grid/inline-edit/datetime.blade.php ENDPATH**/ ?>