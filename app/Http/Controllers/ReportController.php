<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Laporan Transaksi Penjualan (Owner, Manager).
     * Mendukung filter rentang tanggal.
     */
    public function transactions(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Sale::with(['cashier', 'branch', 'details']);

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        // Ambil semua data untuk statistik
        $allSales = (clone $query)->get();

        // Ambil data untuk tabel dengan pagination
        $sales = $query
            ->latest('transaction_date')
            ->paginate(10)
            ->withQueryString();

        $totalTransaction = $allSales->count();
        $totalRevenue = $allSales->sum('total');
        $totalItemsSold = $allSales->sum(function ($sale) {
            return $sale->details->sum('qty');
        });

        return view('reports.transactions', compact(
            'sales',
            'startDate',
            'endDate',
            'totalTransaction',
            'totalRevenue',
            'totalItemsSold'
        ));
    }

    /**
     * Laporan Stok (Owner, Manager, Warehouse).
     * Menampilkan stok terkini tiap produk + riwayat pergerakan stok dengan filter tanggal.
     */
    public function stock(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        $movementQuery = StockMovement::with(['product', 'user']);

        if ($startDate) {
            $movementQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $movementQuery->whereDate('created_at', '<=', $endDate);
        }

        // Ambil semua data untuk statistik
        $allMovements = (clone $movementQuery)->get();

        // Ambil data untuk tabel dengan pagination
        $movements = $movementQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $totalStockIn = $allMovements
            ->where('type', 'IN')
            ->sum('quantity');

        $totalStockOut = $allMovements
            ->where('type', 'OUT')
            ->sum('quantity');

        $lowStockProducts = $products->filter(function ($product) {
            return $product->stock <= $product->minimum_stock;
        });

        return view('reports.stock', compact(
            'products',
            'movements',
            'startDate',
            'endDate',
            'totalStockIn',
            'totalStockOut',
            'lowStockProducts'
        ));
    }
}
