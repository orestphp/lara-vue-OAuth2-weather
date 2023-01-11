<?php

use App\Http\Controllers\API\v1\UserController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [UserController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [UserController::class, 'callbackFromGoogle'])->name('callback');
});
