<div class="<?php echo e($viewClass['form-group'], false); ?> <?php echo ($errors->has($errorKey['start'].'start') || $errors->has($errorKey['end'].'end')) ? 'has-error' : ''; ?>">

    <label for="<?php echo e($id['start'], false); ?>" class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo e($label, false); ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row" style="width: 370px">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="<?php echo e($name['start'], false); ?>" value="<?php echo e(old($column['start'], $value['start'] ?? null), false); ?>" class="form-control <?php echo e($class['start'], false); ?>" autocomplete="off" style="width: 150px" <?php echo $attributes; ?> />
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="<?php echo e($name['end'], false); ?>" value="<?php echo e(old($column['end'], $value['end'] ?? null), false); ?>" class="form-control <?php echo e($class['end'], false); ?>" autocomplete="off" style="width: 150px" <?php echo $attributes; ?> />
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/vendor/encore/laravel-admin/src/../resources/views/form/daterange.blade.php ENDPATH**/ ?>