<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, Product $product = null)
    {
        if(auth()->user()->role === 'customer') {
            toastr()->error('É necessário entrar em contato com um vendedor para realizar compras');
            return back();
        }
        //Adicionando o produto ao carrinho na sessão
        $cart = session('cart', []);

        $product = $product ?? Product::find($request->product_id);

        $quantity = $request->quantity ?? 1;

        if ($product->quantity < $quantity) {
            toastr()->error('Quantidade indisponível em estoque');
            return back();
        }

        //Verifica se o produto já está no carrinho
        $productIndex = array_search($product->id, array_column($cart, 'product_id'));

        if ($productIndex === false) {
            $cart[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        } else {
            //Verifica se a quantidade adicionada é maior que a disponível em estoque
            if ($product->quantity < $cart[$productIndex]['quantity'] + $quantity) {
                toastr()->error('Quantidade indisponível em estoque');
                return back();
            } else{
                $cart[$productIndex]['quantity'] += $quantity;
            }
        }
        session(['cart' => $cart]);

        toastr()->success('Produto adicionado ao carrinho');
        return redirect()->back();
    }

    public function decreaseFromCart(Product $product)
    {
        //Diminuindo a quantidade do produto no carrinho na sessão
        $cart = session('cart', []);

        //Verifica se o produto já está no carrinho
        $productIndex = array_search($product->id, array_column($cart, 'product_id'));

        if ($productIndex !== false) {
            $cart[$productIndex]['quantity']--;

            if ($cart[$productIndex]['quantity'] == 0) {
                unset($cart[$productIndex]);
            }
        }

        session(['cart' => $cart]);

        toastr()->success('Quantidade do produto diminuída');
        return redirect()->back();
    }

    public function removeFromCart(Product $product)
    {
        //Removendo o produto do carrinho na sessão
        $cart = session('cart', []);

        //Verifica se o produto já está no carrinho
        $productIndex = array_search($product->id, array_column($cart, 'product_id'));

        if ($productIndex !== false) {
            unset($cart[$productIndex]);
        }

        session(['cart' => $cart]);

        toastr()->success('Produto removido do carrinho');
        return redirect()->back();
    }

    public function getCart()
    {
        $cart = session('cart', []);

        $count_cart = count(session('cart', []));

        $products = Product::whereIn('id', array_column($cart, 'product_id'))->get();

        return view('sales.cart', compact('cart', 'products'));
    }
}
