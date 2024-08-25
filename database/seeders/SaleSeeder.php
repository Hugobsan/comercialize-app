<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtendo os usuários e produtos necessários
        $sellers = \App\Models\User::where('role', 'seller')->get();
        $customers = \App\Models\User::where('role', 'customer')->get();
        $products = \App\Models\Product::all();

        // Gerando 50 vendas com dados aleatórios
        $sales = \App\Models\Sale::factory(50)->make()->each(function ($sale) use ($sellers, $customers, $products) {
            // Definindo seller_id e customer_id aleatórios
            $sale->seller_id = $sellers->random()->id;
            $sale->customer_id = $customers->random()->id;

            // Definindo uma data de venda aleatória em 2024
            $sale->created_at = Carbon::create(2024, rand(1, 12), rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
            $sale->updated_at = $sale->created_at;

            // Salvando a venda
            $sale->save();

            // Selecionando produtos aleatórios para a venda
            $saleProducts = $products->random(rand(1, 10))->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'quantity' => rand(1, 10),
                    'price' => $product->unformatted_price,
                ];
            });

            // Calculando o total de vendas e a quantidade total
            $totalAmount = $saleProducts->sum(function ($saleProduct) {
                return (int) $saleProduct['quantity'] * (float) $saleProduct['price'];
            });

            $totalQuantity = $saleProducts->sum('quantity');

            // Associando produtos à venda
            $sale->products()->attach($saleProducts);

            // Atualizando a venda com o total calculado
            $sale->update([
                'total_amount' => $totalAmount,
                'total_quantity' => $totalQuantity,
            ]);
        });
    }
}
