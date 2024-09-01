<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated; 
use App\Models\Gen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PestAndDiseaseController;
use Illuminate\Support\Facades\Auth;

Route::get('policy', function () {
    return view('policy');
});
Route::get('app', function () {
    //redirec to url('naro-v3.apk');
    return redirect(url('naro-v3.apk'));
});

//api generation
Route::get('generate-class', [MainController::class, 'generate_class']);
Route::get('/gen', function () {
    die(Gen::find($_GET['id'])->do_get());
})->name("register");
Route::get('/gen-form', function () {
    die(Gen::find($_GET['id'])->make_forms());
})->name("gen-form");

//farmers forum
Route::get('chat', [ChatController::class, 'index']);
Route::post('store', [QuestionController::class, 'store'])->name('store');
Route::post('answers', [QuestionController::class, 'answers'])->name('answers');

//pests and diseases
Route::get('pest-and-diseases', [PestAndDiseaseController::class, 'index'])->name('pest-and-diseases');

Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
