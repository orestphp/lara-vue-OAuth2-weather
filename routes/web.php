<?php

use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\WeatherController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});

Auth::routes();

/**
// Weather json (used for manual testing)
Route::get('/getweather', [WeatherController::class, 'getWeather']);
// User check (used for manual testing)
Route::get('/user/{token}', [UserController::class, 'getUserByToken']);
*/

// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
