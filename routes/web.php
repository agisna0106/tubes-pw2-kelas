<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
// TAMBAHAN: Import Controller milikmu di sini
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;

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
        Route::get('owner/dashboard', [DashboardController::class, 'owner'])->name('owner.dashboard');
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

        Route::get('/reports/inventory',[InventoryReportController::class, 'index'])->name('reports.inventory');
        Route::get('/reports/inventory/pdf',[InventoryReportController::class, 'pdf'])->name('reports.inventory.pdf');
    });

    // Hak akses Transaksi Penjualan (Sesuai kesepakatan: Cashier)
    Route::middleware(['role:cashier'])->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    });

    // Hak akses Laporan Transaksi (Sesuai kesepakatan: Owner & Manager)
    Route::middleware(['role:owner|manager'])->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    });

    // Hak akses Laporan Stok (Sesuai kesepakatan: Owner, Manager, Warehouse)
    Route::middleware(['role:owner|manager|warehouse'])->group(function () {
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    });

    Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::resource('branches', BranchController::class);
});
});

require __DIR__.'/auth.php';