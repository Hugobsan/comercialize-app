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
                @include('products.components.create')
            @endcan
        </div>
        <div>
            <form action="{{ route('products.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-11">
                        <input type="text" class="form-control" name="search" placeholder="Pesquise por nome ou categoria"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-12 col-md-4 col-lg-3">
                    @include('products.components.card_product', ['product' => $product])
                </div>
            @endforeach

            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
