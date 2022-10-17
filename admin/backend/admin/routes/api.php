<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/user', [
    AuthController::class,
    'user'
]);


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
