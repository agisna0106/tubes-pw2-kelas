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

        $sales = $query->latest('transaction_date')->get();

        $totalTransaction = $sales->count();
        $totalRevenue = $sales->sum('total');
        $totalItemsSold = $sales->sum(fn ($sale) => $sale->details->sum('qty'));

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

        $products = Product::with('category')->orderBy('name')->get();

        $movementQuery = StockMovement::with(['product', 'user']);

        if ($startDate) {
            $movementQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $movementQuery->whereDate('created_at', '<=', $endDate);
        }

        $movements = $movementQuery->latest()->get();

        $totalStockIn = $movements->where('type', 'IN')->sum('quantity');
        $totalStockOut = $movements->where('type', 'OUT')->sum('quantity');
        $lowStockProducts = $products->filter(fn ($product) => $product->stock <= $product->minimum_stock);

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
