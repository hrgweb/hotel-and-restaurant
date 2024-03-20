<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserRoleController;

Route::get('/', function () {
    return redirect(route('categories.index'));
    // return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/pos', [PosController::class, 'index']);

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('tables', TableController::class);
Route::resource('user-roles', UserRoleController::class);
Route::resource('staffs', StaffController::class);
Route::resource('orders', OrderController::class);
