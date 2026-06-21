<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'barcode' => '899100100001',
            'name' => 'Espresso',
            'purchase_price' => 8000,
            'selling_price' => 12000,
            'stock' => 50,
            'minimum_stock' => 10,
        ]);

        Product::create([
            'category_id' => 1,
            'barcode' => '899100100002',
            'name' => 'Americano',
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'stock' => 30,
            'minimum_stock' => 10,
        ]);

        Product::create([
            'category_id' => 3,
            'barcode' => '899100100003',
            'name' => 'Croissant',
            'purchase_price' => 7000,
            'selling_price' => 12000,
            'stock' => 20,
            'minimum_stock' => 5,
        ]);
    }
}
