<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Transaksi Penjualan') }}
            </h2>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 print:hidden">
                <div class="p-6">
                    <form action="{{ route('reports.transactions') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1">
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Filter
                            </button>
                            <a href="{{ route('reports.transactions') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hidden print:block text-center mb-6">
                <h1 class="text-lg font-bold">LAPORAN TRANSAKSI PENJUALAN</h1>
                <p class="text-sm">
                    Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }}
                    s/d
                    {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold">{{ $totalTransaction }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Item Terjual</p>
                    <p class="text-2xl font-bold">{{ $totalItemsSold }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-sm text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">No. Invoice</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Cabang</th>
                                <th class="px-6 py-3">Kasir</th>
                                <th class="px-6 py-3">Jumlah Item</th>
                                <th class="px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium">{{ $sale->invoice_number }}</td>
                                    <td class="px-6 py-4">{{ $sale->transaction_date->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">{{ $sale->branch->name ?? $sale->branch->branch_name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $sale->cashier->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $sale->details->sum('qty') }}</td>
                                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada transaksi pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $sales->links() }}
                    </div>
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
