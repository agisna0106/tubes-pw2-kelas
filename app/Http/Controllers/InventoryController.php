<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product', 'user'])->latest()->paginate(10);
        return view('inventory.index', compact('movements'));
    }

    public function stockIn()
    {
        $products = Product::all();
        return view('inventory.stock-in', compact('products'));
    }

    public function storeStockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // 1. Catat pergerakan stok
            StockMovement::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => 'IN',
                'quantity' => $request->quantity,
                'notes' => $request->notes,
            ]);

            // 2. Tambah stok di tabel products
            $product = Product::findOrFail($request->product_id);
            $product->increment('stock', $request->quantity);
        });

        return redirect()->route('inventory.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    public function stockOut()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('inventory.stock-out', compact('products'));
    }

    public function storeStockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'required|string' // Notes wajib untuk barang keluar sebagai alasan
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Jumlah barang keluar melebihi stok yang tersedia!'])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            // 1. Catat pergerakan stok
            StockMovement::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => 'OUT',
                'quantity' => $request->quantity,
                'notes' => $request->notes,
            ]);

            // 2. Kurangi stok di tabel products
            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('inventory.index')->with('success', 'Stok berhasil dikeluarkan.');
    }
}
