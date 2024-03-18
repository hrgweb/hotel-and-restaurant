<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect(route('categories.index'));
    // return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
