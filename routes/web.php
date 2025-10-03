<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index']);

Route::post('/cart/add', [CartController::class, 'store']);

Route::get('/cart', [CartController::class, 'index']);

Route::get('/cart/clear', [CartController::class, 'clear']);

Route::post('/cart/update', [CartController::class, 'update']);

Route::post('/cart/remove', [CartController::class, 'remove']);
