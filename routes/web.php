<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserRoleController;

// Auth
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/', fn () => 'main page')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () =>  view('dashboard'));
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('tables', TableController::class);
    Route::resource('user-roles', UserRoleController::class);
    Route::resource('staffs', StaffController::class);
    Route::resource('orders', OrderController::class);
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);
    Route::post('/payment', [PaymentController::class, 'store']);

    // Pos
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
});
