<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashiers = User::role('cashier')->get();

        for ($i = 1; $i <= 50; $i++) {

            $cashier = $cashiers->random();

            $sale = Sale::create([

                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'branch_id' => $cashier->branch_id,

                'cashier_id' => $cashier->id,

                'total' => 0,

                'transaction_date' => fake()->dateTimeBetween('-30 days'),

            ]);

            $products = Product::inRandomOrder()
                ->take(rand(2, 5))
                ->get();

            $total = 0;

            foreach ($products as $product) {

                $qty = rand(1, 3);

                if ($product->stock < $qty) {
                    continue;
                }

                $subtotal = $qty * $product->selling_price;

                SaleDetail::create([

                    'sale_id' => $sale->id,

                    'product_id' => $product->id,

                    'qty' => $qty,

                    'price' => $product->selling_price,

                    'subtotal' => $subtotal,

                ]);

                $product->decrement('stock', $qty);

                $total += $subtotal;
            }

            $sale->update([
                'total' => $total,
            ]);
        }
    }
}
