<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;

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

        // Verifica se tem dados de pesquisa
        $search = request()->input('search');

        if ($search) {
            //Pesquisa por nome ou categoria
            $products = Product::where('name', 'like', '%' . $search . '%')
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->paginate(8)->appends(['search' => $search]);
        } else {
            $products = Product::paginate(8);
        }

        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'search'));
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
