<?php

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
