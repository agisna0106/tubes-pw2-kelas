<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Manager Dashboard
        </h2>
    </x-slot>

    <div class="py-6 mx-6">

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
                title="Today's Sales"
                :value="'Rp '.number_format($todaySales,0,',','.')"
                icon="fa-solid fa-money-bill-wave"
                color="yellow"/>

            <x-stat-card
                title="Today's Transactions"
                :value="$todayTransactions"
                icon="fa-solid fa-receipt"
                color="purple"/>

        </div>

        <div class="mt-8">

            <h2 class="text-xl font-semibold mb-4">

                Low Stock Products

            </h2>

            <x-table>

                <x-slot name="header">

                    <th>No</th>
                    <th>Product</th>
                    <th>Stock</th>

                </x-slot>

                @forelse($lowStocks as $product)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $product->name }}</td>

                        <td>

                            <span class="text-red-600 font-bold">

                                {{ $product->stock }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3">

                            No data

                        </td>

                    </tr>

                @endforelse

            </x-table>

        </div>

    </div>

</x-app-layout>
