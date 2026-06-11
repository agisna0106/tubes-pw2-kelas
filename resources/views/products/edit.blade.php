<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori <span class="text-red-500">*</span></label>
                                <select id="category_id" name="category_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="barcode" class="block font-medium text-sm text-gray-700">Barcode <span class="text-red-500">*</span></label>
                                <input id="barcode" type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @error('barcode') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @error('name') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="purchase_price" class="block font-medium text-sm text-gray-700">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                                <input id="purchase_price" type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @error('purchase_price') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="selling_price" class="block font-medium text-sm text-gray-700">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                                <input id="selling_price" type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @error('selling_price') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="minimum_stock" class="block font-medium text-sm text-gray-700">Minimal Stok (Peringatan) <span class="text-red-500">*</span></label>
                                <input id="minimum_stock" type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" required min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @error('minimum_stock') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>