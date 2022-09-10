<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
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



Route::get('/user', [
    AuthController::class,
    'user'
]);


// Admin Routes

Route::prefix('admin')->group(function () {
    Route::group([
        'middleware' => 'scope.admin',
    ], (function () {
        Route::get('/clear-cache', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            return response()->json(['status' => 'success']);
        });
        Route::apiResource(
            '/users',
            UserController::class
        );
        Route::post('upload/{product_id}', [
            ImageController::class,
            'upload'
        ]);
        Route::post('delete/{product_id}', [
            ImageController::class,
            'delete'
        ]);
        Route::get('export', [
            OrderController::class,
            'export'
        ]);
        Route::get('chartByDateAndTime', [
            DashboardController::class,
            'chartByDateAndTime'
        ]);
        Route::get('chartByOrderID', [
            DashboardController::class,
            'chartByOrderID'
        ]);
        Route::get('chart', [
            DashboardController::class,
            'chart'
        ]);
        Route::apiResource(
            '/roles',
            RoleController::class
        );
        Route::apiResource(
            '/products',
            ProductController::class
        );
        Route::apiResource(
            '/orders',
            OrderController::class
        )->only([
            'index',
            'show',
        ]);
    }));
});