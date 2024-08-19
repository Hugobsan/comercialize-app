<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sale = [
            'seller_id' => User::where('role', 'seller')->inRandomOrder()->first()->id,
            'customer_id' => User::where('role', 'customer')->inRandomOrder()->first()->id,
            'total_amount' => null,
            'total_quantity' => null,
        ];

        $amountProducts = $this->faker->numberBetween(1, 10);
    
        $products = Product::inRandomOrder()->limit($amountProducts)->get();

        $saleProducts = $products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => $this->faker->numberBetween(1, 10),
                'price' => $product->price,
            ];
        });

        $totalAmount = $saleProducts->sum(function ($saleProduct) {
            return $saleProduct['quantity'] * $saleProduct['price'];
        });

        $totalQuantity = $saleProducts->sum('quantity');

        $sale['total_amount'] = $totalAmount;
        $sale['total_quantity'] = $totalQuantity;

        return $sale;
    }
}
