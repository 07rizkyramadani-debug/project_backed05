<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Controllers\ProductController;

// Wajib menggunakan middleware 'web' agar session & auth terbaca
Route::middleware(['web', 'auth'])->group(function () {
    // Route khusus ditaruh sebelum resource
    Route::get('products/{product}/reduce-stock/{quantity}', [ProductController::class, 'reduceStock'])
        ->whereNumber('quantity')
        ->name('products.reduce-stock');

    Route::resource('products', ProductController::class)->except(['show']);
});
