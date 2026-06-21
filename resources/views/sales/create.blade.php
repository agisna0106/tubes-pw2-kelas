<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Penjualan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @error('items')
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="posCart()">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('sales.store') }}" method="POST" @submit="return submitForm($event)">
                        @csrf

                        <div class="mb-6 hidden">
                            <label for="branch_id" class="block font-medium text-sm text-gray-700">Cabang <span class="text-red-500">*</span></label>
                            <select id="branch_id" name="branch_id" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full md:w-1/2">
                                <option value="" disabled {{ old('branch_id', auth()->user()->branch_id) ? '' : 'selected' }}>-- Pilih Cabang --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id', auth()->user()->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name ?? $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <h3 class="font-semibold text-gray-800 mb-3">Tambah Produk</h3>
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end mb-6">
                            <div class="md:col-span-7">
                                <label class="block font-medium text-sm text-gray-700">Produk</label>
                                <select x-model="selectedProductId" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">-- Pilih Produk --</option>
                                    <template x-for="product in products" :key="product.id">
                                        <option :value="product.id" x-text="`${product.barcode} - ${product.name} (Stok: ${product.stock}) - ${formatRupiah(product.price)}`"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                                <input type="number" min="1" x-model.number="qty" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            </div>
                            <div class="md:col-span-2">
                                <button type="button" @click="addItem()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + Tambah
                                </button>
                            </div>
                        </div>

                        <h3 class="font-semibold text-gray-800 mb-3">Keranjang</h3>
                        <div class="overflow-x-auto border rounded-lg mb-6">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3">Produk</th>
                                        <th class="px-4 py-3">Harga</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3">Subtotal</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="cart.length === 0">
                                        <tr>
                                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada produk di keranjang.</td>
                                        </tr>
                                    </template>
                                    <template x-for="(item, index) in cart" :key="item.product_id">
                                        <tr class="border-t">
                                            <td class="px-4 py-3" x-text="item.name"></td>
                                            <td class="px-4 py-3" x-text="formatRupiah(item.price)"></td>
                                            <td class="px-4 py-3" x-text="item.qty"></td>
                                            <td class="px-4 py-3 font-semibold" x-text="formatRupiah(item.subtotal)"></td>
                                            <td class="px-4 py-3 text-right">
                                                <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                            </td>
                                            <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                                            <input type="hidden" :name="`items[${index}][qty]`" :value="item.qty">
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr class="border-t bg-gray-50 font-bold">
                                        <td class="px-4 py-3" colspan="3">Total</td>
                                        <td class="px-4 py-3" x-text="formatRupiah(total)"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('sales.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 mr-2">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posCart() {
            return {
                products: @json($productsForCart),
                cart: [],
                selectedProductId: '',
                qty: 1,

                get total() {
                    return this.cart.reduce((sum, item) => sum + item.subtotal, 0);
                },

                addItem() {
                    if (!this.selectedProductId || !this.qty || this.qty < 1) {
                        return;
                    }

                    const product = this.products.find(p => p.id == this.selectedProductId);
                    if (!product) return;

                    const existing = this.cart.find(i => i.product_id == product.id);
                    const currentQtyInCart = existing ? existing.qty : 0;

                    if ((this.qty + currentQtyInCart) > product.stock) {
                        alert(`Stok tidak mencukupi. Sisa stok ${product.name}: ${product.stock}`);
                        return;
                    }

                    if (existing) {
                        existing.qty += this.qty;
                        existing.subtotal = existing.qty * existing.price;
                    } else {
                        this.cart.push({
                            product_id: product.id,
                            name: product.name,
                            price: product.price,
                            qty: this.qty,
                            subtotal: product.price * this.qty,
                        });
                    }

                    this.selectedProductId = '';
                    this.qty = 1;
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                formatRupiah(value) {
                    return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
                },

                submitForm(event) {
                    if (this.cart.length === 0) {
                        event.preventDefault();
                        alert('Tambahkan minimal 1 produk ke transaksi sebelum menyimpan.');
                        return false;
                    }
                    return true;
                },
            }
        }
    </script>
</x-app-layout>
