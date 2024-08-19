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

        $sellers->each(function ($seller) use ($customers, $products) {
            $customers->each(function ($customer) use ($seller, $products) {
                $totalQuantity = 0;
                $totalAmount = 0;

                $products->random(5)->each(function ($product) use (&$totalQuantity, &$totalAmount) {
                    $quantity = rand(1, 5);
                    $price = $product->price;

                    $totalQuantity += $quantity;
                    $totalAmount += $quantity * $price;

                    \App\Models\Sale::factory()->create([
                        'seller_id' => $seller->id,
                        'customer_id' => $customer->id,
                        'total_quantity' => $totalQuantity,
                        'total_amount' => $totalAmount,
                    ])->each(function ($sale) use ($product, $quantity, $price) {
                        $sale->products()->attach($product->id, [
                            'quantity' => $quantity,
                            'price' => $price,
                        ]);
                    });
                });
            });
        });
    }
}
