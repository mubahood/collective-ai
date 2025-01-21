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
use App\Models\Utils;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::get('process-price-records', function () {
    Utils::process_price_records();
});
Route::get('gemini', function () {

    /* 
AIzaSyCu9PvyIqV2MP_oES4eHi5JMS2SprAvEWY
curl \
  -H 'Content-Type: application/json' \
  -d '{"contents":[{"parts":[{"text":"Explain how AI works"}]}]}' \
  -X POST 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=YOUR_API_KEY'
*/
    $GOOGLE_API_KEY = 'AIzaSyC9Mdls_ETVjOb_u5bjcqavSI4E8S1D2Vs';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=$GOOGLE_API_KEY",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
            "contents": [{
              "parts":[{"text": "How old is president Kabiala Joseph?"}]
              }]
             }',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));
    //display response
    $response = curl_exec($curl);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    die();

    //in this route we will call the gemini api
    /* 
curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$GOOGLE_API_KEY" \
    -H 'Content-Type: application/json' \
    -X POST \
    -d '{
      "contents": [{
        "parts":[{"text": "Write a story about a magic backpack."}]
        }]
       }' 2> /dev/null
*/
    $curl = curl_init();

    $GOOGLE_API_KEY = 'AIzaSyC9Mdls_ETVjOb_u5bjcqavSI4E8S1D2Vs';
    /* curl_setopt_array($curl, array(
        CURLOPT_URL => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$GOOGLE_API_KEY",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
            "contents": [{
              "parts":[{"text": "What is the best way to grow tomatoes?"}]
              }]
             }',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    die(); */
    //now let us try vision capabilities of gemini, get online photo and try to get a description of it
    $photo_link = 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png';

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$GOOGLE_API_KEY",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(array(
            "contents" => array(
                array(
                    "parts" => array(
                        array(
                            "content" => $photo_link
                        )
                    )
                )
            )
        )),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    die();

    die();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$GOOGLE_API_KEY",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
            "contents": [{
              "parts":[{"image": "' . $photo_link . '"}]
              }]
             }',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
});
Route::get('policy', function () {
    return view('policy');
});
Route::get('migrate', function () {
    //run laravel migrate command in code
    $RESP = Artisan::call('migrate');
    echo "<pre>";
    print_r($RESP);
    echo "</pre>";
    die();
});
Route::get('app', function () {
    //redirec to url('naro-v3.apk');
    return redirect(url('app.apk'));
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

/* Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
 
    return "Cleared!";
 
 });
 */