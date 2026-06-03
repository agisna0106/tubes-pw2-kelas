<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class
        ]);

        $roles = [
            'owner',
            'manager',
            'supervisor',
            'cashier',
            'warehouse',
        ];

        foreach ($roles as $role) {
            $user = User::create([
                'name' => ucfirst($role),
                'username' => $role,
                'email' => $role . '@gmail.com',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            $user->assignRole($role);
        }

    }
}
