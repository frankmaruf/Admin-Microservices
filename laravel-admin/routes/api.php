<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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

// Route::get('/users',[
//     UserController::class,
//     'users'
// ]);

// Route::get('/users/{id}',[
//     UserController::class,
//     'show'
// ]);

// Route::post('/users',[
//     UserController::class,
//     'store'
// ]);

// Route::put('/users/{id}',[
//     UserController::class,
//     'update'
// ]);
// Route::delete('/users/{id}',[
//     UserController::class,
//     'destroy'
// ]);
Route::post('/login', [
    AuthController::class,
    'login'
]);
Route::post('/register', [
    AuthController::class,
    'register'
]);

Route::middleware('auth:api')->group(function (){
    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);
    Route::get('/user', [
        UserController::class,
        'user'
    ]);
    Route::put('/user/info', [
        UserController::class,
        'updateInfo'
    ]);
    Route::put('/user/password', [
        UserController::class,
        'updatePassword'
    ]);
    Route::apiResource(
        '/users',
        UserController::class
    );
    Route::apiResource(
        '/roles',
        RoleController::class
    );
    Route::apiResource(
        '/products',
        ProductController::class
    );
});
// Route::group([
//     'middleware' => ['auth:api'],
//     // 'middleware' => 'api',
//     // 'prefix' => 'auth'
// ], function () {
//     Route::apiResource(
//         '/users',
//         UserController::class
//     );
// });
