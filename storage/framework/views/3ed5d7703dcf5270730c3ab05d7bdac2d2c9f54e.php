<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Scaffold</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <form method="post" action="<?php echo e($action, false); ?>" id="scaffold" pjax-container>

            <div class="box-body">

                <div class="form-horizontal">

                <div class="form-group">

                    <label for="inputTableName" class="col-sm-1 control-label">Table name</label>

                    <div class="col-sm-4">
                        <input type="text" name="table_name" class="form-control" id="inputTableName" placeholder="table name" value="<?php echo e(old('table_name'), false); ?>">
                    </div>

                    <span class="help-block hide" id="table-name-help">
                        <i class="fa fa-info"></i>&nbsp; Table name can't be empty!
                    </span>

                </div>
                <div class="form-group">
                    <label for="inputModelName" class="col-sm-1 control-label">Model</label>

                    <div class="col-sm-4">
                        <input type="text" name="model_name" class="form-control" id="inputModelName" placeholder="model" value="<?php echo e(old('model_name', "App\\Models\\"), false); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputControllerName" class="col-sm-1 control-label">Controller</label>

                    <div class="col-sm-4">
                        <input type="text" name="controller_name" class="form-control" id="inputControllerName" placeholder="controller" value="<?php echo e(old('controller_name', "App\\Admin\\Controllers\\"), false); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked value="migration" name="create[]" /> Create migration
                            </label>
                            <label>
                                <input type="checkbox" checked value="model" name="create[]" /> Create model
                            </label>
                            <label>
                                <input type="checkbox" checked value="controller" name="create[]" /> Create controller
                            </label>
                            <label>
                                <input type="checkbox" checked value="migrate" name="create[]" /> Run migrate
                            </label>
                        </div>
                    </div>
                </div>

                </div>

                <hr />

                <h4>Fields</h4>

                <table class="table table-hover" id="table-fields">
                    <tbody>
                    <tr>
                        <th style="width: 200px">Field name</th>
                        <th>Type</th>
                        <th>Nullable</th>
                        <th>Key</th>
                        <th>Default value</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>

                    <?php if(old('fields')): ?>
                        <?php $__currentLoopData = old('fields'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="text" name="fields[<?php echo e($index, false); ?>][name]" class="form-control" placeholder="field name" value="<?php echo e($field['name'], false); ?>" />
                                </td>
                                <td>
                                    <select style="width: 200px" name="fields[<?php echo e($index, false); ?>][type]">
                                        <?php $__currentLoopData = $dbTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type, false); ?>" <?php echo e($field['type'] == $type ? 'selected' : '', false); ?>><?php echo e($type, false); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="fields[<?php echo e($index, false); ?>][nullable]" <?php echo e(\Illuminate\Support\Arr::get($field, 'nullable') == 'on' ? 'checked': '', false); ?>/></td>
                                <td>
                                    <select style="width: 150px" name="fields[<?php echo e($index, false); ?>][key]">
                                        
                                        <option value="" <?php echo e($field['key'] == '' ? 'selected' : '', false); ?>>NULL</option>
                                        <option value="unique" <?php echo e($field['key'] == 'unique' ? 'selected' : '', false); ?>>Unique</option>
                                        <option value="index" <?php echo e($field['key'] == 'index' ? 'selected' : '', false); ?>>Index</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="default value" name="fields[<?php echo e($index, false); ?>][default]" value="<?php echo e($field['default'], false); ?>"/></td>
                                <td><input type="text" class="form-control" placeholder="comment" name="fields[<?php echo e($index, false); ?>][comment]" value="<?php echo e($field['comment'], false); ?>" /></td>
                                <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <tr>
                        <td>
                            <input type="text" name="fields[0][name]" class="form-control" placeholder="field name" />
                        </td>
                        <td>
                            <select style="width: 200px" name="fields[0][type]">
                                <?php $__currentLoopData = $dbTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type, false); ?>"><?php echo e($type, false); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td><input type="checkbox" name="fields[0][nullable]" /></td>
                        <td>
                            <select style="width: 150px" name="fields[0][key]">
                                
                                <option value="" selected>NULL</option>
                                <option value="unique">Unique</option>
                                <option value="index">Index</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" placeholder="default value" name="fields[0][default]"></td>
                        <td><input type="text" class="form-control" placeholder="comment" name="fields[0][comment]"></td>
                        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a></td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <hr style="margin-top: 0;"/>

                <div class='form-inline margin' style="width: 100%">


                    <div class='form-group'>
                        <button type="button" class="btn btn-sm btn-success" id="add-table-field"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add field</button>
                    </div>

                    <div class='form-group pull-right' style="margin-right: 20px; margin-top: 5px;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked name="timestamps"> Created_at & Updated_at
                            </label>
                            &nbsp;&nbsp;
                            <label>
                                <input type="checkbox" name="soft_deletes"> Soft deletes
                            </label>

                        </div>
                    </div>

                    <div class="form-group pull-right" style="margin-right: 20px;">
                        <label for="inputPrimaryKey">Primary key</label>
                        <input type="text" name="primary_key" class="form-control" id="inputPrimaryKey" placeholder="Primary key" value="id" style="width: 100px;">
                    </div>

                </div>

                

                

                
                    
                    
                        
                        
                        
                        
                        
                        
                        
                    
                    
                

                

                

                    
                        
                    

                

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">submit</button>
            </div>

            <?php echo e(csrf_field(), false); ?>


            <!-- /.box-footer -->
        </form>

    </div>

</div>

<template id="table-field-tpl">
    <tr>
        <td>
            <input type="text" name="fields[__index__][name]" class="form-control" placeholder="field name" />
        </td>
        <td>
            <select style="width: 200px" name="fields[__index__][type]">
                <?php $__currentLoopData = $dbTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type, false); ?>"><?php echo e($type, false); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </td>
        <td><input type="checkbox" name="fields[__index__][nullable]" /></td>
        <td>
            <select style="width: 150px" name="fields[__index__][key]">
                <option value="" selected>NULL</option>
                <option value="unique">Unique</option>
                <option value="index">Index</option>
            </select>
        </td>
        <td><input type="text" class="form-control" placeholder="default value" name="fields[__index__][default]"></td>
        <td><input type="text" class="form-control" placeholder="comment" name="fields[__index__][comment]"></td>
        <td><a class="btn btn-sm btn-danger table-field-remove"><i class="fa fa-trash"></i> remove</a></td>
    </tr>
</template>

<template id="model-relation-tpl">
    <tr>
        <td><input type="text" class="form-control" placeholder="relation name" value=""></td>
        <td>
            <select style="width: 150px">
                <option value="HasOne" selected>HasOne</option>
                <option value="BelongsTo">BelongsTo</option>
                <option value="HasMany">HasMany</option>
                <option value="BelongsToMany">BelongsToMany</option>
            </select>
        </td>
        <td><input type="text" class="form-control" placeholder="related model"></td>
        <td><input type="text" class="form-control" placeholder="default value"></td>
        <td><input type="text" class="form-control" placeholder="default value"></td>
        <td><input type="checkbox" /></td>
        <td><a class="btn btn-sm btn-danger model-relation-remove"><i class="fa fa-trash"></i> remove</a></td>
    </tr>
</template>

<script>

$(function () {

    $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    $('select').select2();

    $('#add-table-field').click(function (event) {
        $('#table-fields tbody').append($('#table-field-tpl').html().replace(/__index__/g, $('#table-fields tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});
    });

    $('#table-fields').on('click', '.table-field-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#add-model-relation').click(function (event) {
        $('#model-relations tbody').append($('#model-relation-tpl').html().replace(/__index__/g, $('#model-relations tr').length - 1));
        $('select').select2();
        $('input[type=checkbox]').iCheck({checkboxClass:'icheckbox_minimal-blue'});

        relation_count++;
    });

    $('#model-relations').on('click', '.model-relation-remove', function(event) {
        $(event.target).closest('tr').remove();
    });

    $('#scaffold').on('submit', function (event) {

        //event.preventDefault();

        if ($('#inputTableName').val() == '') {
            $('#inputTableName').closest('.form-group').addClass('has-error');
            $('#table-name-help').removeClass('hide');

            return false;
        }

        return true;
    });
});

</script><?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/vendor/laravel-admin-ext/helpers/src/../resources/views/scaffold.blade.php ENDPATH**/ ?>