<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengelolaan User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <x-primary-link href="{{ route('users.create') }}">Tambah Data User</x-primary-link>
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
                            <td>{{ $user->branch?->name ?? '-' }}</td>
                            <td>{{ $user->getRoleNames()->first() }}</td>
                            <td class="flex flex-auto">
                                <a href="{{ route('users.edit', $user->id) }}" class="flex items-center justify-center h-20"><i class="fa-solid fa-pencil"></i></a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="post" class="delete-form">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button type="submit" class="bg-transparent hover:bg-transparent active:bg-transparent border-0 shadow-none p-0 flex items-center justify-center h-20"><i class="fa-solid fa-trash text-red-600 ml-1"></i></x-danger-button>
                                    {{-- <x-danger-button type="submit">Delete</x-danger-button> --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        </div>
    </div>


</x-app-layout>
