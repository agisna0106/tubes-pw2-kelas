<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Owner!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <x-stat-card
                title="Total Branch"
                :value="$totalBranches"
                icon="fa-solid fa-building"
                color="blue"/>

            <x-stat-card
                title="Total Users"
                :value="$totalUsers"
                icon="fa-solid fa-users"
                color="green"/>

            <x-stat-card
                title="Total Products"
                :value="$totalProducts"
                icon="fa-solid fa-box-open"
                color="yellow"/>

            <x-stat-card
                title="Current Stock"
                :value="$currentStock"
                icon="fa-solid fa-warehouse"
                color="purple"/>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">

            {{-- <x-stat-card
                title="Today's Sales"
                :value="'Rp '.number_format($todaySales,0,',','.')"
                icon="fa-solid fa-money-bill-wave"
                color="green"/> --}}

            {{-- <x-stat-card
                title="Monthly Sales"
                :value="'Rp '.number_format($monthlySales,0,',','.')"
                icon="fa-solid fa-chart-line"
                color="blue"/> --}}

            {{-- <x-stat-card
                title="Transactions"
                :value="$transactionCount"
                icon="fa-solid fa-receipt"
                color="yellow"/> --}}

            {{-- <x-stat-card
                title="Cashiers"
                :value="$cashierCount"
                icon="fa-solid fa-cash-register"
                color="red"/> --}}

        </div>

        <div class="mt-8">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                {{ __('Low Stock') }}
            </h2>

            <div class="bg-white rounded-lg shadow p-4">

                <x-table>

                    <x-slot name="header">

                        <th>No</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Current Stock</th>

                    </x-slot>

                    @forelse($lowStocks as $product)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $product->name }}</td>

                            <td>
                                {{ $product->category?->name ?? '-' }}
                            </td>

                            <td>

                                <span
                                    class="inline-flex px-2 py-1 rounded-full bg-red-100 text-red-700 font-semibold">

                                    {{ $product->stock }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-4">

                                No low stock products found.

                            </td>

                        </tr>

                    @endforelse

                </x-table>

            </div>

        </div>
    </div>
</x-app-layout>
