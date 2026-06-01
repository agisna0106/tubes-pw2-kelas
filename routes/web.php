<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', function() {
            return "Owner Dashboard";
        });
    });

    Route::middleware(['role:owner|manager'])->group(function () {
        Route::get('/manager/reports', function() {
            return "Manager Reports";
        });
    });

    Route::middleware(['role:owner|manager|supervisor'])->group(function () {
        Route::get('/supervisor/monitoring', function() {
            return "Supervisor Monitoring";
        });
    });

    Route::middleware(['role:owner|manager|supervisor|cashier'])->group(function () {
        Route::get('/cashier/transactions', function() {
            return "Cashier Tansaction Page";
        });
    });

    Route::middleware(['role:owner|manager|supervisor|warehouse'])->group(function () {
        Route::get('/warehouse/stock', function() {
            return "Warehose Stock Page";
        });
    });


});

require __DIR__.'/auth.php';
