<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'branch_id' => null,
        ])->assignRole('owner');

        User::create([
            'name' => 'Manager',
            'username' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
        ])->assignRole('manager');

        User::create([
            'name' => 'Supervisor',
            'username' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
        ])->assignRole('supervisor');

        User::create([
            'name' => 'Cashier',
            'username' => 'cashier',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
        ])->assignRole('cashier');

        User::create([
            'name' => 'Warehouse',
            'username' => 'warehouse',
            'email' => 'warehouse@gmail.com',
            'password' => Hash::make('password'),
            'branch_id' => 1,
        ])->assignRole('warehouse');
    }
}
