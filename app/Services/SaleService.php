<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function createSale(array $data)
    {
        DB::transaction(function () use ($data) {
            $sale = $this->createAndUpdateSale($data);

            // Atualizar o total_amount e total_quantity da venda
            $sale->update([
                'total_amount' => $this->calculateTotalAmount($sale),
                'total_quantity' => $this->calculateTotalQuantity($sale),
            ]);

            return $sale;
        });
    }

    public function updateSale(Sale $sale, array $data)
    {
        DB::transaction(function () use ($sale, $data) {
            // Restaurar o estoque dos produtos da venda anterior
            $this->restoreStock($sale);

            $sale = $this->createAndUpdateSale($data, $sale);

            // Atualizar o total_amount e total_quantity da venda
            $sale->update([
                'total_amount' => $this->calculateTotalAmount($sale),
                'total_quantity' => $this->calculateTotalQuantity($sale),
            ]);
        });
    }

    public function deleteSale(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Restaurar o estoque dos produtos da venda
            $this->restoreStock($sale);

            // Excluir a venda
            $sale->delete();
        });
    }

    protected function createAndUpdateSale(array $data, Sale $sale = null)
    {
        $sale = $sale ?? new Sale([
            'user_id' => $data['user_id'],
            'client_id' => $data['client_id'],
        ]);

        $this->checkStock($data['products']);

        if ($sale->exists) {
            $sale->products()->detach();
        }

        foreach ($data['products'] as $productData) {
            $sale->products()->attach($productData['id'], ['quantity' => $productData['quantity']]);

            // Atualizar estoque
            $product = Product::find($productData['id']);
            $product->quantity -= $productData['quantity'];
            $product->save();
        }

        if (!$sale->exists) {
            $sale->save();
        }

        return $sale;
    }

    protected function checkStock(array $products)
    {
        foreach ($products as $productData) {
            $product = Product::find($productData['id']);
            if ($product->quantity < $productData['quantity']) {
                throw new \Exception("Product {$productData['id']} does not have enough stock.");
            }
        }
    }

    protected function restoreStock(Sale $sale)
    {
        foreach ($sale->products as $product) {
            $existingProduct = Product::find($product->id);
            $existingProduct->quantity += $product->pivot->quantity;
            $existingProduct->save();
        }
    }

    protected function calculateTotalAmount(Sale $sale)
    {
        $totalAmount = 0;
        foreach ($sale->products as $product) {
            $totalAmount += $product->pivot->quantity * $product->price;
        }
        return $totalAmount;
    }

    protected function calculateTotalQuantity(Sale $sale)
    {
        return $sale->products->sum('pivot.quantity');
    }
}
