<?php

use App\Http\Controllers\API\v1\UserController;
use App\Models\User;
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

Route::get('/user/{id}', function (Request $request) {
    $user = User::where('id', $request->id);
    return response()->json($user);
});

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [UserController::class, 'loginWithGoogle'])->name('api.login');
    Route::any('callback', [UserController::class, 'callbackFromGoogle'])->name('api.callback');
});
