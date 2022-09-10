<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfluencerLinkController;
use App\Http\Controllers\InfluencerProductController;
use App\Http\Controllers\InfluencerStatsController;
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


Route::get("/products", [
    InfluencerProductController::class,
    'index'
]);
Route::get('/user', [
    AuthController::class,
    'user'
]);
Route::group([
    'middleware' => 'scope.influencer'
], function () {
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
});
