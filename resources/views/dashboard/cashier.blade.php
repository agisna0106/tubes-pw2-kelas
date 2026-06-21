<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl">

            Cashier Dashboard

        </h2>

    </x-slot>

    <div class="py-6 mx-6">

        <h2 class="text-2xl font-bold">

            Welcome Back,

            {{ auth()->user()->name }}

        </h2>

        <p class="text-gray-500">

            Branch :

            {{ auth()->user()->branch?->name ?? '-' }}

        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">

            <x-stat-card
                title="Today's Sales"
                :value="'Rp '.number_format($todaySales,0,',','.')"
                icon="fa-solid fa-money-bill-wave"
                color="green"/>

            <x-stat-card
                title="Transactions"
                :value="$todayTransactions"
                icon="fa-solid fa-receipt"
                color="blue"/>

            <x-stat-card
                title="Products Sold"
                :value="$productsSold"
                icon="fa-solid fa-box"
                color="yellow"/>

            <x-stat-card
                title="Average Transaction"
                :value="'Rp '.number_format($averageTransaction,0,',','.')"
                icon="fa-solid fa-chart-line"
                color="purple"/>

        </div>
        <div class="mt-8">

            <a
                href="{{ route('sales.create') }}"
                class="w-full block text-center bg-blue-600 text-white py-5 rounded-xl text-xl font-bold hover:bg-blue-700">

                + Start New Transaction

            </a>

        </div>
        <div class="mt-8">

            <h2 class="text-xl font-semibold mb-4">

                Recent Transactions

            </h2>

            <div class="bg-white rounded-lg shadow p-4">

                <x-table>

                    <x-slot name="header">

                        <th>No</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Date</th>

                    </x-slot>

                    @forelse($recentTransactions as $transaction)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $transaction->invoice_number }}

                            </td>

                            <td>

                                Rp
                                {{ number_format($transaction->total,0,',','.') }}

                            </td>

                            <td>

                                {{ $transaction->transaction_date }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-4">

                                    No transaction available.

                            </td>

                        </tr>

                    @endforelse

                </x-table>

            </div>

        </div>

    </div>

</x-app-layout>
