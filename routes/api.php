<?php

use App\Http\Controllers\API\v1\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
// User
Route::get('/user/{token}', function (Request $request) {
    $user = User::where('token', $request->segment(3))->first();
    if($user && $user->expires_in) {
        $endTime = strtotime(date("Y-m-d H:i:s", strtotime($user->updated_at.' +'.$user->expires_in.' seconds')));
        if(time() > $endTime) {
            // Logout
            return response()->json([]);
        }
    }
    return response()->json($user);
});

// Google URL
Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [UserController::class, 'loginWithGoogle']);
    Route::any('callback', [UserController::class, 'callbackFromGoogle']);
});
