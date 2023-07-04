<?php

use App\Http\Controllers\API\OrdersController;
use Illuminate\Support\Facades\Route;

Route::post('/orders',          [OrdersController::class, 'store']);
Route::post('/orders/capture',  [OrdersController::class, 'capture']);
