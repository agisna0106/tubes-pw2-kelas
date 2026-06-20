<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Branch Report') }}
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow rounded p-4">

                <table class="table-auto w-full">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Branch</th>
                            <th>Manager</th>
                            <th>Total Users</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($branches as $branch)

                        <tr>
                            <td>{{ $branch->id }}</td>

                            <td>{{ $branch->name }}</td>

                            <td>
                                {{ $branch->manager?->name ?? '-' }}
                            </td>

                            <td>
                                {{ $branch->users->count() }}
                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
