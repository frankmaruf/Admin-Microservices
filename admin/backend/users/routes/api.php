<?php

use App\Http\Controllers\AuthController;
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

Route::post('/login',[
    AuthController::class,
    'login'
]);
Route::post('/register',[
    AuthController::class,
    'register'
]);

Route::group([
    'middleware' => ['auth:api'],
], (function () {
    Route::get('/user', [
        AuthController::class,
        'user'
    ]);
    Route::put('/user/info', [
        AuthController::class,
        'updateInfo'
    ]);
    Route::get('admin', [
        AuthController::class,
        'authenticated'
    ])->middleware('scope:admin');
    Route::get('influencer', [
        AuthController::class,
        'authenticated'
    ])->middleware('scope:influencer');
    Route::put('/user/password', [
        AuthController::class,
        'updatePassword'
    ]);
    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);
}));

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
