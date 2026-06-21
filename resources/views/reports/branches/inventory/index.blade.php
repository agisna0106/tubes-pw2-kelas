<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory Report') }}
        </h2>
    </x-slot>

    <div class="p-3 mx-3">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('reports.inventory.pdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Export PDF
            </a>
        </div>
    </div>



    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <form method="GET">

                <input
                    type="date"
                    name="start_date">

                <input
                    type="date"
                    name="end_date">

                <x-primary-button type="submit">
                    Filter
                </x-primary-button>

            </form>

            <x-table>

                    <x-slot name="header">

                        <th>No</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>User</th>
                        <th>Notes</th>

                    </x-slot>

                    @forelse($movements as $movement)

                        <tr class="border-b">

                            <td>
                                {{ $loop->iteration }}
                            </td>

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

                        <td>
                            {{ $movement->quantity }}
                        </td>

                        <td>
                            {{ $movement->user->name }}
                        </td>

                        <td>
                            {{ $movement->notes }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Tidak ada data
                        </td>
                    </tr>

                @endforelse

            </x-table>
        </div>


    </div>

</x-app-layout>
