<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Daftar transaksi penjualan.
     * Kasir hanya melihat transaksi miliknya sendiri.
     */
    public function index()
    {
        $query = Sale::with(['cashier', 'branch'])->latest('transaction_date');

        if (Auth::user()->hasRole('cashier')) {
            $query->where('cashier_id', Auth::id());
        }

        $sales = $query->paginate(15);

        return view('sales.index', compact('sales'));
    }

    /**
     * Form transaksi penjualan baru (POS sederhana).
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $branches = Branch::all();

        // Disiapkan sebagai variabel tunggal (bukan ekspresi inline) supaya aman
        // dipakai di dalam @json() pada view — directive @json() memecah argumen
        // berdasarkan koma, jadi ekspresi map()/closure langsung di dalamnya bisa rusak.
        $productsForCart = $products->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'barcode' => $p->barcode,
            'price' => (float) $p->selling_price,
            'stock' => $p->stock,
        ])->values();

        return view('sales.create', compact('products', 'branches', 'productsForCart'));
    }

    /**
     * Simpan transaksi penjualan + detail + kurangi stok otomatis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ], [
            'items.required' => 'Tambahkan minimal 1 produk ke transaksi.',
            'items.min' => 'Tambahkan minimal 1 produk ke transaksi.',
        ]);

        $cashier = Auth::user();

        try {
            $sale = DB::transaction(function () use ($validated, $cashier) {
                $total = 0;
                $rows = [];

                foreach ($validated['items'] as $item) {
                    // Lock baris produk supaya stok aman dari transaksi paralel
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                    if ($item['qty'] > $product->stock) {
                        throw new \RuntimeException("Stok produk \"{$product->name}\" tidak mencukupi (sisa: {$product->stock}).");
                    }

                    $subtotal = $product->selling_price * $item['qty'];
                    $total += $subtotal;

                    $rows[] = [
                        'product' => $product,
                        'qty' => $item['qty'],
                        'price' => $product->selling_price,
                        'subtotal' => $subtotal,
                    ];
                }

                $sale = Sale::create([
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'branch_id' => $validated['branch_id'],
                    'cashier_id' => $cashier->id,
                    'total' => $total,
                    'transaction_date' => now(),
                ]);

                foreach ($rows as $row) {
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $row['product']->id,
                        'qty' => $row['qty'],
                        'price' => $row['price'],
                        'subtotal' => $row['subtotal'],
                    ]);

                    // Kurangi stok otomatis
                    $row['product']->decrement('stock', $row['qty']);

                    // Catat juga ke riwayat pergerakan stok (konsisten dengan modul Inventory)
                    StockMovement::create([
                        'product_id' => $row['product']->id,
                        'user_id' => $cashier->id,
                        'type' => 'OUT',
                        'quantity' => $row['qty'],
                        'notes' => 'Penjualan - Invoice ' . $sale->invoice_number,
                    ]);
                }

                return $sale;
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['items' => $e->getMessage()])->withInput();
        }

        return redirect()->route('sales.show', $sale)->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Detail / struk transaksi (bisa dicetak).
     */
    public function show(Sale $sale)
    {
        if (Auth::user()->hasRole('cashier') && $sale->cashier_id !== Auth::id()) {
            abort(403);
        }

        $sale->load(['details.product', 'cashier', 'branch']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Generate nomor invoice unik: INV-YYYYMMDD-XXXX
     */
    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');

        $count = Sale::whereDate(
            'transaction_date',
            now()->toDateString()
        )->count() + 1;

        do {

            $invoiceNumber = 'INV-' .
                $date .
                '-' .
                str_pad($count, 4, '0', STR_PAD_LEFT);

            $count++;

        } while (
            Sale::where('invoice_number', $invoiceNumber)->exists()
        );

        return $invoiceNumber;
    }
}
