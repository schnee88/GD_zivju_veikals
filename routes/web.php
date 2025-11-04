<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLISKĀS LAPAS (bez autentifikācijas)
// ============================================

// Galvenā mājas lapa
Route::get('/', function () {
    return view('home');
})->name('home');

// Zivju katalogs un veikals
Route::get('/catalog', [FishController::class, 'catalog'])->name('fish.catalog');
Route::get('/shop', [FishController::class, 'orderable'])->name('fish.shop');
Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');

// Partiju skats
Route::get('/zavejumi', [BatchController::class, 'publicIndex'])->name('batches.public');

// ============================================
// AUTENTIFIKĀCIJA
// ============================================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// LIETOTĀJA ZONA (autentificētiem)
// ============================================
Route::middleware('auth')->group(function () {
    
    // GROZS (veikalam)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // PASŪTĪJUMI
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// ============================================
// ADMIN PANELIS
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Atskaites
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('admin.reports.orders');

    // ZIVIS
    Route::get('/fish', [FishController::class, 'adminIndex'])->name('admin.fish.index');
    Route::get('/fish/create', [FishController::class, 'create'])->name('admin.fish.create');
    Route::post('/fish', [FishController::class, 'store'])->name('admin.fish.store');
    Route::get('/fish/{id}/edit', [FishController::class, 'edit'])->name('admin.fish.edit');
    Route::put('/fish/{id}', [FishController::class, 'update'])->name('admin.fish.update');
    Route::delete('/fish/{id}', [FishController::class, 'destroy'])->name('admin.fish.destroy');

    // PARTIJAS (Batches)
    Route::get('/batches', [BatchController::class, 'index'])->name('admin.batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('admin.batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('admin.batches.store');
    Route::get('/batches/{batch}/edit', [BatchController::class, 'edit'])->name('admin.batches.edit');
    Route::put('/batches/{batch}', [BatchController::class, 'update'])->name('admin.batches.update');
    Route::patch('/batches/{batch}/status', [BatchController::class, 'updateStatus'])->name('admin.batches.update-status');
    Route::delete('/batches/{batch}', [BatchController::class, 'destroy'])->name('admin.batches.destroy');

    // PASŪTĪJUMI (admin pārvaldība)
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});