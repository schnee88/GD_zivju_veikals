<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Galvenā mājas lapa
Route::get('/', function () {
    return view('home');
})->name('home');

// Zivju saraksts
Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');
Route::get('/zavejumi', [BatchController::class, 'publicIndex'])->name('batches.public');

// Autentifikācija
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rezervācijas un grozs (tikai autentificētiem lietotājiem)
Route::middleware('auth')->group(function () {
    // Grozs
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Rezervācijas
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/checkout', [ReservationController::class, 'checkout'])->name('reservations.checkout');
    Route::post('/reservations/checkout', [ReservationController::class, 'storeFromCart'])->name('reservations.storeFromCart');
    Route::get('/reservations/success', [ReservationController::class, 'success'])->name('reservations.success');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

//ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Zivis
    Route::get('/fish', [FishController::class, 'adminIndex'])->name('admin.fish.index');
    Route::get('/fish/create', [FishController::class, 'create'])->name('admin.fish.create');
    Route::post('/fish', [FishController::class, 'store'])->name('admin.fish.store');
    Route::get('/fish/{id}/edit', [FishController::class, 'edit'])->name('admin.fish.edit');
    Route::put('/fish/{id}', [FishController::class, 'update'])->name('admin.fish.update');
    Route::delete('/fish/{id}', [FishController::class, 'destroy'])->name('admin.fish.destroy');

    // Batches
    Route::get('/batches', [BatchController::class, 'index'])->name('admin.batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('admin.batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('admin.batches.store');
    Route::get('/batches/{batch}/edit', [BatchController::class, 'edit'])->name('admin.batches.edit');
    Route::put('/batches/{batch}', [BatchController::class, 'update'])->name('admin.batches.update');
    Route::get('/batches/{batch}', [BatchController::class, 'show'])->name('admin.batches.show');
    Route::patch('/batches/{batch}/status', [BatchController::class, 'updateStatus'])->name('admin.batches.update-status');
    Route::delete('/batches/{batch}', [BatchController::class, 'destroy'])->name('admin.batches.destroy');
    Route::post('/batches/update-fish-status', [BatchController::class, 'updateFishStatus'])->name('admin.batches.update-fish-status');
    Route::post('/batches/bulk-update-fish-status', [BatchController::class, 'bulkUpdateFishStatus'])->name('admin.batches.bulk-update-fish-status');

    // Rezervācijas (admin)
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('admin.reservations.index');
    Route::get('/reservations/{id}', [ReservationController::class, 'adminShow'])->name('admin.reservations.show');
    Route::patch('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.updateStatus');
});
