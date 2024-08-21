<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/add-to-cart/{product}', [SaleController::class, 'addToCart'])->name('sales.add-to-cart');
    Route::get('/remove-from-cart/{product}', [SaleController::class, 'removeFromCart'])->name('sales.remove-from-cart');
    Route::get('/clear-cart', [SaleController::class, 'clearCart'])->name('sales.clear-cart');
    Route::delete('/remove-item/{sale_product}', [SaleController::class, 'removeItem'])->name('sales.remove-item');
    Route::resource('sales', SaleController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    
});