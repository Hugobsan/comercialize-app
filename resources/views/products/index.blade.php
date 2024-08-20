@extends('layouts.app')

@section('title', 'Produtos')

@push('styles')
    <style>
        .paginator {
            margin-top: 20px;
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container d-flex flex-column align-content-center justify-content-center">
        <div class="topo">
            <h1>Produtos</h1>
            @can('create', App\Models\Product::class)
                <!-- Modal button -->
                <button type="button" class="btn-new" data-bs-toggle="modal" data-bs-target="#create_product">
                    <i class="fas fa-plus"></i> Novo Produto
                </button>

                <!-- Modal -->
                {{-- @include('livros.components.criar') --}}
            @endcan
        </div>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card my-3">
                        <img src="{{ $product->photo }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                            <div style="color: {{ $product->category->color ?? '#33f' }}">
                                <i class="{{ $product->category->icon }}"></i>
                                {{ $product->category->name }}
                            </div>
                            <p class="card-text">R$ {{ $product->price }}</p>
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <a href="{{ route('sales.add-to-cart', $product->id) }}" class="btn btn-success" data-bs-toggle="tooltip" title="Adicionar ao carrinho de compras">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('products.show', $product->id) }}">Ver</a></li>
                                        @can('update', $product)
                                            <li><a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a></li>
                                        @endcan
                                        @can('delete', $product)
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li class="btn-danger">
                                                <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">Excluir</button>
                                                </form>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
