<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Stok') }}
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
                    <form action="{{ route('reports.stock') }}" method="GET" class="flex flex-wrap items-end gap-4">
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
                            <a href="{{ route('reports.stock') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hidden print:block text-center mb-6">
                <h1 class="text-lg font-bold">LAPORAN STOK</h1>
                <p class="text-sm">
                    Periode pergerakan: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }}
                    s/d
                    {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Barang Masuk</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalStockIn }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Barang Keluar</p>
                    <p class="text-2xl font-bold text-red-600">{{ $totalStockOut }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Produk Stok Menipis</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $lowStockProducts->count() }}</p>
                </div>
            </div>

            <!-- Stok Terkini -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 pt-6">
                    <h3 class="font-semibold text-gray-800">Stok Produk Saat Ini</h3>
                </div>
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-sm text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">Barcode</th>
                                <th class="px-6 py-3">Produk</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Stok Saat Ini</th>
                                <th class="px-6 py-3">Stok Minimum</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $product->barcode }}</td>
                                    <td class="px-6 py-4">{{ $product->name }}</td>
                                    <td class="px-6 py-4">{{ $product->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 font-semibold">{{ $product->stock }}</td>
                                    <td class="px-6 py-4">{{ $product->minimum_stock }}</td>
                                    <td class="px-6 py-4">
                                        @if($product->stock <= $product->minimum_stock)
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400">STOK MENIPIS</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">AMAN</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Riwayat Pergerakan Stok -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6">
                    <h3 class="font-semibold text-gray-800">Riwayat Pergerakan Stok</h3>
                </div>
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-sm text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Petugas</th>
                                <th class="px-6 py-3">Produk</th>
                                <th class="px-6 py-3">Tipe</th>
                                <th class="px-6 py-3">Jumlah</th>
                                <th class="px-6 py-3">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movements as $movement)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">{{ $movement->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $movement->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($movement->type === 'IN')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">MASUK</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">KELUAR</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold">{{ $movement->quantity }}</td>
                                    <td class="px-6 py-4">{{ $movement->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada pergerakan stok pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4 flex justify-end">
                        {{ $movements->links() }}
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
