<?php

use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::where('is_available', true)->get();

    return view('welcome', compact('products'));
});

Route::get('/halo', function () {
    return 'Halo, saya sedang belajar Laravel!';
});

Route::get('/pesan/{product}', [OrderController::class, 'create'])
    ->name('orders.create');

Route::post('/pesan/{product}', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/pesanan/{order}', [OrderController::class, 'show'])
    ->name('orders.show');
