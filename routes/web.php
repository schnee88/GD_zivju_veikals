<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Galvenā mājas lapa ar info par veikalu
Route::get('/', function () { return view('home');})->name('home');

// Zivju saraksts (atsevišķā lapa)
Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');

Route::get('/zavejumi', [BatchController::class, 'publicIndex'])->name('batches.public');

// Autentifikācija
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


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

    Route::get('/batches', [BatchController::class, 'index'])->name('admin.batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('admin.batches.create');
    Route::post('/batches', [BatchController::class, 'store'])->name('admin.batches.store');
    Route::get('/batches/{batch}/edit', [BatchController::class, 'edit'])->name('admin.batches.edit');

    Route::get('/batches/{batch}', [BatchController::class, 'show'])->name('admin.batches.show');
    Route::patch('/batches/{batch}/status', [BatchController::class, 'updateStatus'])->name('admin.batches.update-status');
    Route::delete('/batches/{batch}', [BatchController::class, 'destroy'])->name('admin.batches.destroy');

    Route::post('/batches/update-fish-status', [BatchController::class, 'updateFishStatus'])->name('admin.batches.update-fish-status');
    Route::post('/batches/bulk-update-fish-status', [BatchController::class, 'bulkUpdateFishStatus'])->name('admin.batches.bulk-update-fish-status');
    
    
    Route::resource('fish', FishController::class)->except(['show', 'index']);
});