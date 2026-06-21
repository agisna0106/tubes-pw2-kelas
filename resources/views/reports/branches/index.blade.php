<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Branch Report') }}
        </h2>
    </x-slot>

    <div class="py-6 mx-6">
        <div class="max-w-7xl mx-auto">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <x-stat-card
                title="Total Branch"
                :value="$totalBranches"
                icon="fa-solid fa-building"
                color="blue"/>

                <x-stat-card
                title="Total Manager"
                :value="$totalManagers"
                icon="fa-solid fa-user-tie"
                color="green"/>

            </div>

            {{-- Tombol Export --}}
            <div class="flex justify-end mb-4">

                <x-primary-link
                href="{{ route('reports.branches.pdf') }}">

                    <i class="fa-solid fa-file-pdf mr-2"></i>

                    Export PDF

                </x-primary-link>

            </div>


            <div class="bg-white shadow rounded p-4">

                <x-table>

                    <x-slot name="header">

                        <th>No</th>
                        <th>Branch</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Manager</th>

                    </x-slot>

                    @forelse($branches as $branch)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $branch->name }}</td>

                            <td>{{ $branch->city }}</td>

                            <td>{{ $branch->address }}</td>

                            <td>{{ $branch->phone }}</td>

                            <td>{{ $branch->manager?->name ?? '-' }}</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No data available.

                            </td>

                        </tr>

                    @endforelse

                </x-table>

            </div>

        </div>

    </div>

</x-app-layout>
