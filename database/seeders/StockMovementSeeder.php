<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;
use App\Models\StockMovement;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouseUsers = User::role(['warehouse', 'supervisor'])->get();

        for ($i = 1; $i <= 100; $i++) {

            $product = Product::inRandomOrder()->first();

            $type = fake()->randomElement(['IN', 'OUT']);

            $qty = rand(1, 20);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $warehouseUsers->random()->id,
                'type' => $type,
                'quantity' => $qty,
                'notes' => fake()->sentence(),
                'created_at' => fake()->dateTimeBetween('-30 days'),
            ]);

            if ($type == 'IN') {

                $product->increment('stock', $qty);

            } else {

                if ($product->stock >= $qty) {

                    $product->decrement('stock', $qty);

                }

            }
        }
    }
}
