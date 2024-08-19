@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="container">
        <div class="topo">
            {{dd(Auth::user()->can('create', App\Models\Livro::class))}}
            <h1>Livros</h1>
            @can('create', App\Models\Livro::class)
                <!-- Modal button -->
                <button type="button" class="btn-new" data-bs-toggle="modal" data-bs-target="#create_product">
                    <i class="fas fa-plus"></i> Novo Produto
                </button>

                <!-- Modal -->
                {{-- @include('livros.components.criar') --}}
            @endcan
        </div>
        <div class="tabela table-responsive" style="overflow-x:hidden">
            <div>
                <form action="#" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control" name="pesquisa"
                                placeholder="Pesquise por nome ou categoria">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td scope="row">{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm"><i
                                        class="fas fa-bars"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum produto encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
