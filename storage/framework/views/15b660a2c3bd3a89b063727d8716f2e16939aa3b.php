$(document).off('click', '.ie-content .ie-submit').on('click', '.ie-content .ie-submit', function () {

    var $popover = $(this).closest('.ie-content');
    var $trigger = $popover.data('trigger');

    <?php if(isset($val)): ?>
        <?php echo e($val, false); ?>

    <?php else: ?>
        var val = $popover.find('.ie-input').val();
    <?php endif; ?>

    var original = $trigger.data('original');

    if (val == original) {
        $('[data-toggle="popover"]').popover('hide');
        return;
    }

    var data = {
        _token: LA.token,
        _method: 'PUT',
        _edit_inline: true,
    };
    data[$trigger.data('name')] = val;

    $.ajax({
        url: "<?php echo e($resource, false); ?>/" + $trigger.data('key'),
        type: "POST",
        data: data,
        success: function (data) {
            toastr.success(data.message);

            <?php echo e($slot, false); ?>


            $trigger.data('value', val)
                .data('original', val);

            $('[data-toggle="popover"]').popover('hide');
        },
        statusCode: {
            422: function(xhr) {
                $popover.find('.error').empty();
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    $popover.find('.error').append('<div><i class="fa fa-times-circle-o"></i> '+errors[key]+'</div>')
                }
            }
        }
    });
});
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/vendor/encore/laravel-admin/src/../resources/views/grid/inline-edit/partials/submit.blade.php ENDPATH**/ ?>