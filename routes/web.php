<?php 

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FishController::class, 'index'])->name('home');
Route::get('/fish/{id}', [FishController::class, 'show'])->name('fish.show');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('fish', FishController::class)->except(['show', 'index']);
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::put('/orders/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
});