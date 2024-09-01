<?php

/* $d = shell_exec('git pull');
dd($d);
die(); */

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;
use App\Admin\Extensions\Nav\Shortcut;
use App\Admin\Extensions\Nav\Dropdown;
use App\Http\Controllers\ApiResurceController;
use App\Models\Utils;
use Dflydev\DotAccessData\Util;

//Utils::importFarmers(); 

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {

    /*     $u = Auth::user();
    $navbar->left(view('admin.search-bar', [
        'u' => $u
    ]));

    $navbar->left(Shortcut::make([
        'News post' => 'news-posts/create',
        'Products or Services' => 'products/create',
        'Jobs and Opportunities' => 'jobs/create',
        'Event' => 'events/create',
    ], 'fa-plus')->title('ADD NEW'));
    $navbar->left(Shortcut::make([
        'Person with disability' => 'people/create',
        'Association' => 'associations/create',
        'Group' => 'groups/create',
        'Service provider' => 'service-providers/create',
        'Institution' => 'institutions/create',
        'Counselling Centre' => 'counselling-centres/create',
    ], 'fa-wpforms')->title('Register new'));

    $navbar->left(new Dropdown());

    $navbar->right(Shortcut::make([
        'How to update your profile' => '',
        'How to register a new person with disability' => '',
        'How to register as service provider' => '',
        'How to register to post a products & services' => '',
        'How to register to apply for a job' => '',
        'How to register to use mobile App' => '',
        'How to register to contact us' => '',
        'How to register to give a testimonial' => '',
        'How to register to contact counselors' => '',
    ], 'fa-question')->title('HELP')); */
});

//disable batch select in grid
\Encore\Admin\Grid::init(function (\Encore\Admin\Grid $grid) {
    $grid->disableBatchActions();
});

//disable tools in form
\Encore\Admin\Form::init(function (\Encore\Admin\Form $form) {
    $form->tools(function (\Encore\Admin\Form\Tools $tools) {
        $tools->disableDelete();
    });
    $form->disableReset();
    $form->disableViewCheck();
    $form->disableViewCheck();
});

Encore\Admin\Form::forget(['map', 'editor']);
Admin::css(url('/assets/css/bootstrap.css'));
Admin::css('/assets/css/styles.css');
//js https://cdn.jsdelivr.net/npm/chart.js
/* Admin::js('https://cdn.jsdelivr.net/npm/chart.js'); */
ApiResurceController::process_farmers_accounts();
