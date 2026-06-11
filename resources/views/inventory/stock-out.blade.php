<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Barang Keluar (Stock Out)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('inventory.store-out') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="product_id" class="block font-medium text-sm text-gray-700">Pilih Produk (Yang Memiliki Stok) <span class="text-red-500">*</span></label>
                            <select id="product_id" name="product_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="" disabled selected>-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->barcode }} - {{ $product->name }} (Sisa Stok: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                            @error('product_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block font-medium text-sm text-gray-700">Jumlah Keluar <span class="text-red-500">*</span></label>
                            <input id="quantity" type="number" name="quantity" min="1" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            @error('quantity') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block font-medium text-sm text-gray-700">Alasan Keluar (Wajib) <span class="text-red-500">*</span></label>
                            <textarea id="notes" name="notes" rows="3" required placeholder="Contoh: Barang rusak, expired, retur, dll." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"></textarea>
                            @error('notes') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kurangi Stok
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>