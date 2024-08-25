<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleProductController;
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
    Route::get('/home', function () {
        return view('index');
    })->name('index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/update-item/{saleProduct}', [SaleController::class, 'updateItem'])->name('sales.update-item');
    Route::delete('/remove-item/{saleProduct}', [SaleController::class, 'removeItem'])->name('sales.remove-item');
    Route::resource('sales', SaleController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword'])->name('users.reset');
    Route::resource('users', UserController::class);
    
    Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
        Route::get('/add/{product?}', [CartController::class, 'addToCart'])->name('add');
        Route::get('/decrease/{product}', [CartController::class, 'decreaseFromCart'])->name('decrease');
        Route::get('/update/{product}', [CartController::class, 'updateCart'])->name('update');
        Route::get('/remove/{product}', [CartController::class, 'removeFromCart'])->name('remove');
        Route::get('/clear', [CartController::class, 'clearCart'])->name('clear');
        Route::get('/', [CartController::class, 'getCart'])->name('index');
    });

});
