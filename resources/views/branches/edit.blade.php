<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Branch
        </h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('branches.update', $branch->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Nama Branch</label>
                <input type="text" name="name" value="{{ old('name', $branch->name) }}" class="w-full border rounded p-2">
                @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label>Kota</label>
                <input type="text" name="city" value="{{ old('city', $branch->city) }}" class="w-full border rounded p-2">
                @error('city') <div class="text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label>Alamat</label>
                <textarea name="address" class="w-full border rounded p-2">{{ old('address', $branch->address) }}</textarea>
                @error('address') <div class="text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label>Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="w-full border rounded p-2">
                @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label>Manager</label>
                <select name="manager_id" class="w-full border rounded p-2">
                    <option value="">-- Pilih Manager --</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ old('manager_id', $branch->manager_id) == $manager->id ? 'selected' : '' }}>
                            {{ $manager->name }}
                        </option>
                    @endforeach
                </select>
                @error('manager_id') <div class="text-red-600">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>

            <a href="{{ route('branches.index') }}" class="ml-2 text-gray-600">
                Kembali
            </a>
        </form>
    </div>
</x-app-layout>