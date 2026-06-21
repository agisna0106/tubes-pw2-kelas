<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Transaksi Penjualan') }}
            </h2>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full whitespace-nowrap text-sm text-left">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">No. Invoice</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Cabang</th>
                                <th class="px-6 py-3">Kasir</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium">{{ $sale->invoice_number }}</td>
                                    <td class="px-6 py-4">{{ $sale->transaction_date->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">{{ $sale->branch->name ?? $sale->branch->branch_name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $sale->cashier->name ?? '-' }}</td>
                                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Struk</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($sales->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $sales->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
