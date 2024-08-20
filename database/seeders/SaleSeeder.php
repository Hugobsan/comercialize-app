<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = \App\Models\User::where('role', 'seller')->get();
        $customers = \App\Models\User::where('role', 'customer')->get();
        $products = \App\Models\Product::all();

        $sales = \App\Models\Sale::factory(50)->make()->each(function ($sale) use ($sellers, $customers, $products) {
            $sale->seller_id = $sellers->random()->id;
            $sale->customer_id = $customers->random()->id;
            $sale->save();

            $saleProducts = $products->random(rand(1, 10))->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'quantity' => rand(1, 10),
                    'price' => $product->unformatted_price,
                ];
            });

            $totalAmount = $saleProducts->sum(function ($saleProduct) {
                return (int) $saleProduct['quantity'] * (float) $saleProduct['price'];
            });

            $totalQuantity = $saleProducts->sum('quantity');

            $sale->products()->attach($saleProducts);
            $sale->update([
                'total_amount' => $totalAmount,
                'total_quantity' => $totalQuantity,
            ]);
        });
    }
}
