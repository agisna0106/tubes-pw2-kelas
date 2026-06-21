<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div class="max-w-xl">
                        <x-input-label for="name" value="Name"/>
                        <x-text-input id="name" type="text" name="name" class="mt-1 block w-full" value="{{ old('name', $user->name)}}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="username" value="Username"/>
                        <x-text-input id="username" type="text" name="username" class="mt-1 block w-full" value="{{ old('username', $user->username)}}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="email" value="Email"/>
                        <x-text-input id="email" type="email" name="email" class="mt-1 block w-full" value="{{ old('email', $user->email)}}" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="password" value="Password"/>
                        <x-text-input id="password" type="text" name="password" class="mt-1 block w-full" value="{{ old('password')}}"/>
                        <p class="text-gray-500">Kosongkan jika tidak perlu diubah</p>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <div class="max-w-xl">
                        <x-input-label for="branch_id" value="Cabang"/>
                        <x-select-input id="branch_id" name="branch_id" class="mt-1 block w-full">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option
                                    value="{{ $branch->id }}"
                                    {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </x-select-input>
                    </div>

                    @php
                        $currentRole = $user->roles->first()?->name;
                    @endphp

                    <div class="max-w-xl">
                        <x-input-label for="role" value="Role"/>
                        <x-select-input id="role" name="role" class="mt-1 block w-full" required>
                            <option value="">Open this select menu</option>
                            @foreach($roles as $role)
                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </x-select-input>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-secondary-button tag="a" href="">Cancel</x-secondary-button>
                        <x-primary-button name="save_and_create" value="true">Save & Create Another</x-primary-button>
                        <x-primary-button type="submit" name="submit" value="true">Save</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
