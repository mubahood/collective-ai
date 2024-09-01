<?php

$title = isset($title) ? $title : 'Title';
$style = isset($style) ? $style : 'success';
$number = isset($number) ? $number : '0.00';
$sub_title = isset($sub_title) ? $sub_title : 'Sub-titles';
$link = isset($link) ? $link : 'javascript:;';

if (!isset($is_dark)) {
    $is_dark = true;
}
$is_dark = ((bool) $is_dark);

$bg = '';
$text = 'text-primary';
$border = 'border-primary';
$text2 = 'text-dark';
if ($is_dark) {
    $bg = 'bg-primary';
    $text = 'text-white';
    $text2 = 'text-white';


}

if($style == 'danger'){
    $text = 'text-white';
    $bg = 'bg-danger';
    $text2 = 'text-white';
    $border = 'border-danger';
}
?><a href="<?php echo e($link, false); ?>" class="card <?php echo e($bg, false); ?> <?php echo e($border, false); ?> mb-4 mb-md-5">
    <div class="card-body py-0">
        <p class="h3  text-bold mb-2 mb-md-3 <?php echo e($text, false); ?> "><?php echo e($title, false); ?></p>
        <p class="  m-0 text-right <?php echo e($text2, false); ?> h3" style="line-height: 3.2rem"><?php echo e($number, false); ?></p>
        <p class="mt-4 <?php echo e($text2, false); ?>"><?php echo e($sub_title, false); ?></p>
    </div>
</a>
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/resources/views/widgets/box-5.blade.php ENDPATH**/ ?>