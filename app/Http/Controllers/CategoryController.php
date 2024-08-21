<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth()->user()->can('view', Category::class)) {
            toastr()->error('Você não tem permissão para visualizar categorias');
            return redirect()->route('index');
        }

        // Verifica se tem dados de pesquisa
        $search = request()->input('search');

        if ($search) {
            //Pesquisa por nome ou código
            $categories = Category::where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orderBy('name')->paginate(15)->appends(['search' => $search]);
        } else {
            $categories = Category::orderBy('name')->paginate(15);
        }
        
        return view('categories.index', compact('categories', 'search'));
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
    public function store(StoreCategoryRequest $request)
    {
        $request->validated();

        Category::create($request->all());

        toastr()->success('Categoria cadastrada com sucesso');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $request->validated();

        $category->update($request->all());

        toastr()->success('Categoria atualizada com sucesso');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!auth()->user()->can('delete', $category)) {
            toastr()->error('Você não tem permissão para excluir categorias');
            return redirect()->route('index');
        }

        $category->delete();

        toastr()->success('Categoria excluída com sucesso');
        return redirect()->route('categories.index');
    }
}
