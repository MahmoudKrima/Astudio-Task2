<?php

use App\Http\Controllers\Api\Order\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Project\ProjectController;



Route::controller(OrderController::class)
    ->group(function () {
        Route::get('/orders', 'index');
        Route::get('/orders/{project}', 'show');
        Route::post('/orders', 'store');
    });
