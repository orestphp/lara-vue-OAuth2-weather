<?php

use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\WeatherController;
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
// User check
Route::get('/user/{token}', [UserController::class, 'getUserByToken']);
// User destroy
Route::delete('/user/{token}', [UserController::class, 'deleteUser']);
// Weather
Route::get('/getweather', [WeatherController::class, 'getWeather']);

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [UserController::class, 'loginWithGoogle']);
    Route::any('callback', [UserController::class, 'callbackFromGoogle']);
});
