<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', 'AuthController@login');

Route::middleware('auth')->group(function () {
    Route::get('/logout', 'AuthController@logout');
    Route::resource('sales', 'SaleController');
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');
    Route::resource('users', 'UserController');
});