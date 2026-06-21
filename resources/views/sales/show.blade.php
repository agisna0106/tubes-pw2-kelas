<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Struk Transaksi') }} - {{ $sale->invoice_number }}
            </h2>
            <div class="space-x-2">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cetak Struk
                </button>
                <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-6 print:hidden">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="text-center mb-6">
                        <h1 class="text-lg font-bold uppercase">{{ $sale->branch->name ?? $sale->branch->branch_name ?? 'Cabang' }}</h1>
                        <p class="text-sm text-gray-500">Bukti Transaksi Penjualan</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-sm mb-6">
                        <div><span class="text-gray-500">No. Invoice</span><br><span class="font-semibold">{{ $sale->invoice_number }}</span></div>
                        <div><span class="text-gray-500">Tanggal</span><br><span class="font-semibold">{{ $sale->transaction_date->format('d/m/Y H:i') }}</span></div>
                        <div><span class="text-gray-500">Kasir</span><br><span class="font-semibold">{{ $sale->cashier->name ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Cabang</span><br><span class="font-semibold">{{ $sale->branch->name ?? $sale->branch->branch_name ?? '-' }}</span></div>
                    </div>

                    <table class="w-full text-sm text-left mb-6">
                        <thead class="border-b-2 border-gray-300">
                            <tr>
                                <th class="py-2">Produk</th>
                                <th class="py-2 text-right">Harga</th>
                                <th class="py-2 text-right">Qty</th>
                                <th class="py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->details as $detail)
                                <tr class="border-b">
                                    <td class="py-2">{{ $detail->product->name ?? 'Produk dihapus' }}</td>
                                    <td class="py-2 text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="py-2 text-right">{{ $detail->qty }}</td>
                                    <td class="py-2 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-300 font-bold text-base">
                                <td class="py-3" colspan="3">TOTAL</td>
                                <td class="py-3 text-right">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <p class="text-center text-xs text-gray-400">Terima kasih atas pembelian Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, header, .print\:hidden { display: none !important; }
            main { margin: 0 !important; }
        }
    </style>
</x-app-layout>
