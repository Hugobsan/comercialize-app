<?php

namespace App\Listeners;

use App\Events\SaleCreate;
use App\Mail\LowStock;
use App\Mail\ThankForBuying;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class HandleSaleCreate
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(SaleCreate $event): void
    {
        //Verifica se o estoque dos produtos da venda estão abaixo de 10
        $products = [];
        foreach ($event->sale->products as $product) {
            if ($product->quantity < 10) {
                $products[] = $product;
            }
        }

        //Envia um email para todos os administradores
        if (count($products)) {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new LowStock($products));
            }
        }


        //Envia um email para o cliente agradecendo a compra
        Mail::to($event->sale->customer->email)->send(new ThankForBuying($event->sale));
    }
}
