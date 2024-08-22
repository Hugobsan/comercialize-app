<?php

namespace App\Observers;

use App\Models\Sale;

class SaleObserver
{
    //Incrementando estoque de produto ao deletar a venda
    public function deleting(Sale $sale)
    {
        foreach ($sale->products as $product) {
            $product->quantity += $product->pivot->quantity;
            $product->save();
        }

        $sale->saleProducts();     
    }
}
