<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\SaleProduct;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view', Sale::class)) {
            toastr()->error('Você não tem permissão para acessar essa página');
            return redirect()->back();
        }

        // Verifica se tem dados de pesquisa
        $search = request()->input('search');

        if ($search) {
            //Pesquisa por data, cliente, produto ou categoria de produto
            $sales = Sale::where('created_at', 'like', '%' . $search . '%')
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('seller', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('products', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                })
                ->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);
        } else {
            $sales = Sale::orderBy('created_at', 'desc')->paginate(10);
        }

        // $sales = Sale::orderBy('created_at', 'desc')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = User::where('role', 'seller')->get();
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        $cart = session('cart', []);

        //parsing cart->product_id to product
        $cart_products = array_map(function ($item) use ($products) {
            $product = $products->firstWhere('id', $item['product_id']);
            $item['product'] = $product;
            return $item;
        }, $cart);
        
        //Calculando o total a partir do valor atual dos produtos no banco
        $total = array_reduce($cart_products, function ($carry, $item) {
            return $carry + (float) $item['product']->unformatted_price * $item['quantity'];
        }, 0);

        return view('sales.create', compact('sellers', 'customers', 'products', 'cart_products', 'total'));
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
        if (!auth()->user()->can('view', $sale)) {
            toastr()->error('Você não tem permissão para visualizar vendas');
            return redirect()->route('index');
        }

        return view('sales.show', compact('sale'));
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
        if (!auth()->user()->can('delete', $sale)) {
            toastr()->error('Você não tem permissão para deletar vendas');
            return redirect()->route('index');
        }

        $sale->delete();

        toastr()->success('Venda deletada com sucesso');
        return redirect()->route('sales.index');
    }

    public function addToCart(Request $request, Product $product = null)
    {
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

    public function removeItem(SaleProduct $saleProduct)
    {
        if (!auth()->user()->can('delete', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para deletar itens da venda');
            return redirect()->route('index');
        }

        $saleProduct->delete();

        toastr()->success('Item removido da venda');
        return back();
    }

    public function updateItem(SaleProduct $saleProduct)
    {
        if (!auth()->user()->can('update', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para atualizar itens da venda');
            return redirect()->route('index');
        }



        $saleProduct->quantity = request()->quantity;
        $saleProduct->save();

        toastr()->success('Quantidade atualizada');
        return back();
    }
}
