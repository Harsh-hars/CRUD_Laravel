<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('products.index');
// });

Route::get('/', [ProductController::class, 'index'])->middleware('auth')->name('products.index');

Route::get('/create', [ProductController::class, 'create'])->name('products.create');

Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

Route::post('/', [ProductController::class, 'store'])->name('products.store');

Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');

Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
