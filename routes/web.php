<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    return redirect(route('categories.index'));
    // return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('tables', TableController::class);
