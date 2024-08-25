<?php

namespace App\Observers;

use App\Models\SaleProduct;

class SaleProductObserver
{
    public function created(SaleProduct $saleProduct)
    {
        //Atualizando total_amount
        $saleProduct->sale->total_amount += (float) $saleProduct->price * (int) $saleProduct->quantity;

        //Atualizando total_quantity
        $saleProduct->sale->total_quantity += (int) $saleProduct->quantity;
        $saleProduct->sale->save();

        //Atualizando quantity em Product
        $saleProduct->product->quantity -= (int) $saleProduct->quantity;
        $saleProduct->product->save();
    }

    public function updating(SaleProduct $saleProduct)
    {
        //Atualizando total_amount
        $saleProduct->sale->total_amount -= (float) $saleProduct->getOriginal('price') * (int) $saleProduct->getOriginal('quantity');
        $saleProduct->sale->total_amount += (float) $saleProduct->price * (int) $saleProduct->quantity;

        //Atualizando total_quantity
        $saleProduct->sale->total_quantity -= (int) $saleProduct->getOriginal('quantity');
        $saleProduct->sale->total_quantity += (int) $saleProduct->quantity;

        $saleProduct->sale->save();

        //Atualizando quantity em Product
        $saleProduct->product->quantity += (int) $saleProduct->getOriginal('quantity');
        $saleProduct->product->quantity -= (int) $saleProduct->quantity;

        $saleProduct->product->save();
    }

    public function deleting(SaleProduct $saleProduct)
    {   
        //Atualizando total_amount
        $saleProduct->sale->total_amount -= (float) $saleProduct->price * (int) $saleProduct->quantity;

        //Atualizando total_quantity
        $saleProduct->sale->total_quantity -= (int) $saleProduct->quantity;
        $saleProduct->sale->save();

        //Atualizando quantity em Product
        $saleProduct->product->quantity += (int) $saleProduct->quantity;
        $saleProduct->product->save();
    }
}
