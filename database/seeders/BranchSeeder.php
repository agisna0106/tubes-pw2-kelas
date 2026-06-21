<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'name' => 'Cibeber',
            'city' => 'Cianjur',
            'address' => 'Jl. Raya Cibeber',
            'phone' => '081111111111',
        ]);

        Branch::create([
            'name' => 'Sukaresmi',
            'city' => 'Cianjur',
            'address' => 'Jl. Raya Sukaresmi',
            'phone' => '082222222222',
        ]);

        Branch::create([
            'name' => 'Cipanas',
            'city' => 'Cianjur',
            'address' => 'Jl. Raya Cipanas',
            'phone' => '083333333333',
        ]);
    }
}
