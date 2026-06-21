<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Warehouse Dashboard
        </h2>
    </x-slot>

    <div class="py-6 mx-6">
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

                <x-stat-card
                    title="Total Product"
                    :value="$totalProducts"
                    icon="fa-solid fa-box"
                    color="blue"/>

                <x-stat-card
                    title="Current Stock"
                    :value="$currentStock"
                    icon="fa-solid fa-warehouse"
                    color="green"/>

                <x-stat-card
                    title="Stock In Today"
                    :value="$stockInToday"
                    icon="fa-solid fa-arrow-down"
                    color="yellow"/>

                <x-stat-card
                    title="Stock Out Today"
                    :value="$stockOutToday"
                    icon="fa-solid fa-arrow-up"
                    color="red"/>

            </div>

            <div class="mt-8">

                <h2 class="text-xl font-semibold mb-4">

                    Low Stock Products

                </h2>

                <div class="bg-white rounded-lg shadow p-4">

                    <x-table>

                        <x-slot name="header">

                            <th>No</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>

                        </x-slot>

                        @forelse($lowStocks as $product)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $product->name }}</td>

                                <td>{{ $product->category?->name ?? '-' }}</td>

                                <td>

                                    <span
                                        class="px-2 py-1 rounded bg-red-100 text-red-700 font-semibold">

                                        {{ $product->stock }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center">

                                    No low stock products.

                                </td>

                            </tr>

                        @endforelse

                    </x-table>

                </div>

            </div>
            <div class="mt-8">

                <h2 class="text-xl font-semibold mb-4">

                    Latest Stock Movements

                </h2>

                <div class="bg-white rounded-lg shadow p-4">

                    <x-table>

                        <x-slot name="header">

                            <th>No</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>User</th>

                        </x-slot>

                        @forelse($latestMovements as $movement)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $movement->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td>
                                    {{ $movement->product->name }}
                                </td>

                                <td>

                                    @if($movement->type == 'IN')

                                        <span class="text-green-600 font-semibold">
                                            Stock In
                                        </span>

                                    @else

                                        <span class="text-red-600 font-semibold">
                                            Stock Out
                                        </span>

                                    @endif

                                </td>

                                <td>{{ $movement->quantity }}</td>

                                <td>{{ $movement->user->name }}</td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    No stock movement found.

                                </td>

                            </tr>

                        @endforelse

                    </x-table>

                </div>

            </div>
        </div>

    </div>

</x-app-layout>

