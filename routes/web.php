<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
// TAMBAHAN: Import Controller milikmu di sini
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hak akses Owner
    Route::middleware(['role:owner'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Hak akses Kategori dan Produk (Sesuai kesepakatan: Owner & Supervisor)
    Route::middleware(['role:owner|supervisor'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });

    // Hak akses Inventori (Sesuai kesepakatan: Owner, Supervisor, Warehouse)
    Route::middleware(['role:owner|supervisor|warehouse'])->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        
        Route::get('/inventory/stock-in', [InventoryController::class, 'stockIn'])->name('inventory.stock-in');
        Route::post('/inventory/stock-in', [InventoryController::class, 'storeStockIn'])->name('inventory.store-in');
        
        Route::get('/inventory/stock-out', [InventoryController::class, 'stockOut'])->name('inventory.stock-out');
        Route::post('/inventory/stock-out', [InventoryController::class, 'storeStockOut'])->name('inventory.store-out');
    });

    // Sisanya biarkan kosong untuk anggota lain
    Route::middleware(['role:owner|manager'])->group(function () {
        // Laporan
    });

    Route::middleware(['role:owner|manager|supervisor|cashier'])->group(function () {
        // Kasir
    });
});

require __DIR__.'/auth.php';