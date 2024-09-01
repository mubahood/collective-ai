<?php

use Illuminate\Routing\Router;


Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('questions', 'HomeController@questions')->name('questions');
    $router->get('question_answers/{id}', 'HomeController@answers')->name('question_answers');
    $router->resource('gens', GenController::class);
    $router->resource('crops', CropController::class);
    $router->resource('crop-protocols', CropProtocolController::class);
    $router->resource('gardens', GardenController::class);
    $router->resource('garden-activities', GardenActivityController::class);
    $router->resource('financial-records', FinancialRecordController::class);
    $router->resource('pests-and-diseases', PestsAndDiseaseController::class);
    $router->resource('groundnut-varieties', GroundnutVarietyController::class);
    $router->resource('products', ProductController::class);
    $router->resource('registrations', RegistrationController::class);
    $router->resource('production-records', ProductionRecordController::class);
    $router->resource('districts', DistrictController::class);
    $router->resource('subcounties', SubcountyController::class);
    $router->resource('parishes', ParishController::class);
    $router->resource('pests-and-disease-reports', PestsAndDiseaseReportController::class);
    $router->resource('farmers', FarmerController::class);
    $router->resource('users', MemberController::class);
    $router->resource('service-providers', ServiceProviderController::class);
    

});
