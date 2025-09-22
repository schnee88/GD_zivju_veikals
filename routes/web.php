<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Galvenā mājas lapa ar info par veikalu
// Tas meklēs resources/views/home.blade.php
Route::get('/', function () { return view('home');})->name('home');

// Zivju saraksts (atsevišķā lapa)
Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');

// Autentifikācija
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lietotāja pasūtījumi
Route::middleware('auth')->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Administratora panelis
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/fish', [FishController::class, 'adminIndex'])->name('admin.fish.index');
    Route::get('/fish/create', [FishController::class, 'create'])->name('admin.fish.create');
    Route::post('/fish', [FishController::class, 'store'])->name('admin.fish.store');
    Route::get('/fish/{id}/edit', [FishController::class, 'edit'])->name('admin.fish.edit');
    Route::put('/fish/{id}', [FishController::class, 'update'])->name('admin.fish.update');
    Route::delete('/fish/{id}', [FishController::class, 'destroy'])->name('admin.fish.destroy');
    
    Route::resource('fish', FishController::class)->except(['show', 'index']);
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::put('/orders/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
});