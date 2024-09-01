<div class="<?php echo e($viewClass['form-group'], false); ?> <?php echo !$errors->has($errorKey) ? '' : 'has-error'; ?>">

    <label for="<?php echo e($id, false); ?>" class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo e($label, false); ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="<?php echo e($id, false); ?>" class="quill-<?php echo e($id, false); ?>" style="height: <?php echo e($height, false); ?>" data-initialed="false">
            <p><?php echo old($column, $value); ?></p>
        </div>

        <input type="hidden" name="<?php echo e($name, false); ?>" value="<?php echo e(old($column, $value), false); ?>" />

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/vendor/jxlwqq/quill/src/../resources/views/editor.blade.php ENDPATH**/ ?>