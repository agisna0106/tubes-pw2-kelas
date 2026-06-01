<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengelolaan User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">

            </div>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>

                    @php $num=1; @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $num++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->branch?->branch_name }}</td>
                            <td>{{ $user->getRoleNames()->first() }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>


</x-app-layout>
