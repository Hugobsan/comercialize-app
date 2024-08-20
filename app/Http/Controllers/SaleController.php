<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function addToCart(Product $product)
    {
        //Adicionando o produto ao carrinho na sessão
        $cart = session('cart', []);

        //Verifica se o produto já está no carrinho
        $productIndex = array_search($product->id, array_column($cart, 'product_id'));

        if($productIndex === false){
            $cart[] = [
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ];
        } else {
            $cart[$productIndex]['quantity']++;
        }

        session(['cart' => $cart]);

        toastr()->success('Produto adicionado ao carrinho');
        return redirect()->back();
    }
}
