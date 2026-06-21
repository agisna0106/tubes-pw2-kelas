<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Branch Management
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <a href="{{ route('branches.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Tambah Branch
            </a>

            @if(session('success'))
                <div class="mt-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full mt-6 border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Nama Branch</th>
                        <th class="border p-2">Kota</th>
                        <th class="border p-2">Alamat</th>
                        <th class="border p-2">Telepon</th>
                        <th class="border p-2">Manager</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($branches as $branch)
                        <tr>
                            <td class="border p-2">{{ $loop->iteration }}</td>
                            <td class="border p-2">{{ $branch->name }}</td>
                            <td class="border p-2">{{ $branch->city }}</td>
                            <td class="border p-2">{{ $branch->address }}</td>
                            <td class="border p-2">{{ $branch->phone }}</td>
                            <td class="border p-2">{{ $branch->manager->name ?? '-' }}</td>
                            <td class="border p-2">
                                <a href="{{ route('branches.edit', $branch->id) }}" class="text-blue-600">
                                    Edit
                                </a>

                                <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus branch ini?')" class="text-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border p-4 text-center">
                                Belum ada data branch.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
