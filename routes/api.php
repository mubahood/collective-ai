<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiResurceController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\GardenController;
use App\Http\Controllers\GardenActivityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionAnswerController;
use Illuminate\Http\Request;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get("service-providers", [ApiResurceController::class, "service_providers"]);
    Route::get("gardens", [ApiResurceController::class, "gardens"]);
    Route::get("financial-records", [ApiResurceController::class, "financial_records"]);
    Route::get("pests-and-disease-reports", [ApiResurceController::class, "pests_and_disease_reports"]);
    Route::get('parishes', [ApiResurceController::class, 'parishes_2']);
    Route::get('farmers', [ApiResurceController::class, 'farmers']);
    Route::get("garden-activities", [ApiResurceController::class, "garden_activities"]);
    Route::get("garden-activities", [ApiResurceController::class, "garden_activities"]);
    Route::POST("gardens", [ApiResurceController::class, "garden_create"]);
    Route::POST("pests-report", [ApiResurceController::class, "pests_report"]);
    Route::POST("financial-records", [ApiResurceController::class, "financial_records_cerate"]);
    Route::POST("products", [ApiResurceController::class, "product_create"]);
    Route::POST("garden-activities", [ApiResurceController::class, "activity_submit"]);
});
Route::get("crops", [ApiResurceController::class, "crops"]);
Route::POST("users/login", [ApiAuthController::class, "login"]);
Route::POST("users/register", [ApiAuthController::class, "register"]);
Route::resource('registration', RegistrationController::class);
//Route::resource('crops', CropController::class);
//Route::resource('gardens', GardenController::class);
Route::resource('garden_activities', GardenActivityController::class);
Route::resource('questions', QuestionAnswerController::class);














Route::get("people", [ApiResurceController::class, "people"]);
Route::POST("people", [ApiResurceController::class, "person_create"]);
Route::get("jobs", [ApiResurceController::class, "jobs"]);
//Route::get('api/{model}', [ApiResurceController::class, 'index']);
Route::get('api/{model}', [ApiResurceController::class, 'my_list']);
Route::get('groups', [ApiResurceController::class, 'groups']);
Route::get('associations', [ApiResurceController::class, 'associations']);
Route::get('institutions', [ApiResurceController::class, 'institutions']);
Route::get('service-providers', [ApiResurceController::class, 'service_providers']);
Route::get('counselling-centres', [ApiResurceController::class, 'counselling_centres']);
Route::get('products', [ApiResurceController::class, 'products']);
Route::get('events', [ApiResurceController::class, 'events']);
Route::get('news-posts', [ApiResurceController::class, 'news_posts']);
Route::POST('farmers', [ApiResurceController::class, 'farmers_create']);
Route::get('process-farmers-accounts', [ApiResurceController::class, 'process_farmers_accounts']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ajax', function (Request $r) {

    $_model = trim($r->get('model'));
    $conditions = [];
    foreach ($_GET as $key => $v) {
        if (substr($key, 0, 6) != 'query_') {
            continue;
        }
        $_key = str_replace('query_', "", $key);
        $conditions[$_key] = $v;
    }

    if (strlen($_model) < 2) {
        return [
            'data' => []
        ];
    }

    $model = "App\Models\\" . $_model;
    $search_by_1 = trim($r->get('search_by_1'));
    $search_by_2 = trim($r->get('search_by_2'));

    $q = trim($r->get('q'));

    $res_1 = $model::where(
        $search_by_1,
        'like',
        "%$q%"
    )
        ->where($conditions)
        ->limit(20)->get();
    $res_2 = [];

    if ((count($res_1) < 20) && (strlen($search_by_2) > 1)) {
        $res_2 = $model::where(
            $search_by_2,
            'like',
            "%$q%"
        )
            ->where($conditions)
            ->limit(20)->get();
    }

    $data = [];
    foreach ($res_1 as $key => $v) {
        $name = "";
        if (isset($v->name)) {
            $name = " - " . $v->name;
        }
        $data[] = [
            'id' => $v->id,
            'text' => "#$v->id" . $name
        ];
    }
    foreach ($res_2 as $key => $v) {
        $name = "";
        if (isset($v->name)) {
            $name = " - " . $v->name;
        }
        $data[] = [
            'id' => $v->id,
            'text' => "#$v->id" . $name
        ];
    }

    return [
        'data' => $data
    ];
});
