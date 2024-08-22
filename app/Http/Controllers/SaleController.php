<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\SaleProduct;

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
        if(!auth()->user()->can('view', $sale)) {
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
        if(!auth()->user()->can('delete', $sale)) {
            toastr()->error('Você não tem permissão para deletar vendas');
            return redirect()->route('index');
        }

        $sale->delete();

        toastr()->success('Venda deletada com sucesso');
        return redirect()->route('sales.index');
    }

    public function addToCart(Product $product)
    {
        //Adicionando o produto ao carrinho na sessão
        $cart = session('cart', []);

        //Verifica se o produto já está no carrinho
        $productIndex = array_search($product->id, array_column($cart, 'product_id'));

        if ($productIndex === false) {
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

    public function removeItem(SaleProduct $saleProduct)
    {
        if(!auth()->user()->can('delete', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para deletar itens da venda');
            return redirect()->route('index');
        }

        $saleProduct->delete();

        toastr()->success('Item removido da venda');
        return back();
    }

    public function updateItem(SaleProduct $saleProduct){
        if(!auth()->user()->can('update', $saleProduct->sale)) {
            toastr()->error('Você não tem permissão para atualizar itens da venda');
            return redirect()->route('index');
        }

        

        $saleProduct->quantity = request()->quantity;
        $saleProduct->save();

        toastr()->success('Quantidade atualizada');
        return back();
    }
}
