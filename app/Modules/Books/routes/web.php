<?php

use Illuminate\Support\Facades\Route;
use Modules\Books\Controllers\BookController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::resource('books', BookController::class)->except(['show']);
});
