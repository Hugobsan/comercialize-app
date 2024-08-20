<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Verifica se o usuário tem permissão de visualizar produtos
        if (!auth()->user()->can('view', Product::class)) {
            toastr()->error('Você não tem permissão para visualizar produtos');
            return redirect()->route('index');
        }

        $products = Product::paginate(8);

        return view('products.index', compact('products'));
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
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!auth()->user()->can('delete', $product)) {
            toastr()->error('Você não tem permissão para deletar produtos');
            return back();
        }

        $product->delete();

        toastr()->success('Produto deletado com sucesso');
        return redirect()->route('products.index');
    }
}
