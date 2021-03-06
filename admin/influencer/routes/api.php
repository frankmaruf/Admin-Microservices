<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Checkout\CheckoutLinkController;
use App\Http\Controllers\Checkout\CheckoutOrderController;
use App\Http\Controllers\Influencer\InfluencerLinkController;
use App\Http\Controllers\Influencer\InfluencerProductController;
use App\Http\Controllers\Influencer\InfluencerStatsController;
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



// Admin Routes

Route::prefix('admin')->group(function () {
    Route::post('/login', [
        AuthController::class,
        'login'
    ]);
    Route::post('/register', [
        AuthController::class,
        'register'
    ]);
    Route::group([
        'middleware' => ['auth:api', 'scope:admin'],
    ], (function () {
        Route::get('/clear-cache', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            return response()->json(['status' => 'success']);
        });        
        Route::get('/user', [
            AuthController::class,
            'user'
        ]);
        Route::put('/user/info', [
            AuthController::class,
            'updateInfo'
        ]);
        Route::put('/user/password', [
            AuthController::class,
            'updatePassword'
        ]);
        Route::post('/logout', [
            AuthController::class,
            'logout'
        ]);
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


// influencer Routes


Route::prefix('influencer')->group(function () {
    Route::post('/login', [
        AuthController::class,
        'login'
    ]);
    Route::post('/register', [
        AuthController::class,
        'register'
    ]);
    Route::get("/products", [
        InfluencerProductController::class,
        'index'
    ]);
    Route::group([], (function () {
        Route::group([
            'middleware' => ['auth:api', 'scope:influencer']
        ], function () {
            Route::get('/user', [
                AuthController::class,
                'user'
            ]);
            Route::put('/user/info', [
                AuthController::class,
                'updateInfo'
            ]);
            Route::put('/user/password', [
                AuthController::class,
                'updatePassword'
            ]);
            Route::post('/logout', [
                AuthController::class,
                'logout'
            ]);
            Route::post('/links', [
                InfluencerLinkController::class,
                'store'
            ]);
            Route::get('/stats', [
                InfluencerStatsController::class,
                'index'
            ]);
            Route::get('/rankings', [
                InfluencerStatsController::class,
                'rankings'
            ]);
            // Route::get("/your_products", [
            //     InfluencerProductController::class,
            //     'influencerProducts'
            // ]);
        });
    }));
});



// Checkout Routes
Route::group([
    'prefix' => 'checkout',
], (function () {
    Route::get("/links/{link}", [
        CheckoutLinkController::class,
        'show'
    ]);
    Route::post('orders', [
        CheckoutOrderController::class,
        'store'
    ]);
    // Route::post('orders/{order}/complete', [
    //     CheckoutOrderController::class,
    //     'complete'
    // ]);
    Route::post('orders/confirm', [
        CheckoutOrderController::class,
        'confirm'
    ]);
}));
