@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @include('products.components.create')
    <section class="container my-3 p-3 bg-white rounded shadow">
        <div class="row">
            <div class="col-12 col-md-4">
                <img src="{{ $product->photo }}" class="img-fluid rounded" alt="{{ $product->name }}">
            </div>
            <div class="col-12 col-md-5 d-flex flex-column justify-content-between">
                <div>
                    <h1>{{ $product->name }}</h1>

                    @isset($product->category)
                        <div style="color: {{ $product->category->color ?? '#33f' }}">
                            <i class="{{ $product->category->icon }}"></i>
                            {{ $product->category->name }}
                        </div>
                        <p>
                            {{ $product->category->description }}
                        </p>
                    @endisset
                    <p>R$ {{ $product->price }}</p>
                    <p class="{{ $product->quantity <= 5 ? 'text-danger' : '' }}">Estoque: {{ $product->quantity }}</p>
                </div>
            </div>
            <div class="col-md-3 d-flex flex-column justify-content-between">
                <div class="d-flex flex-row justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">Voltar</a></li>
                            @can('update', $product)
                                <li><button class="dropdown-item product-edit" data-id="{{ $product->id }}">Editar</button></li>
                            @endcan
                            @can('delete', $product)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="btn-danger
                            ">
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
                <div class="d-flex flex-row justify-content-end">
                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success" data-bs-toggle="tooltip" title="Adicionar ao carrinho de compras">
                        <i class="fas fa-cart-plus"></i> Adicionar ao carrinho
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-3 p-3 bg-white rounded shadow">
        <div class="d-flex flex-row justify-content-between my-2">
            <h2>Vendas</h2>
            <button class="btn btn-danger text-white p-2">
                <i class="fas fa-file-pdf"></i> Exportar relatório
            </button>
        </div>
        @include('products.components.sales_table', ['product' => $product])
    </section>

@endsection

@push('scripts')
    <script>
        @if ($errors->any())
            let product = @json($product);
            editProduct(product);
            $('#create_product').modal('show');
        @endif

        $(document).ready(function() {
            $('.product-edit').click(function() {
                let product = @json($product);
                editProduct(product);
                $('#createProductLabel').text('Editar Produto');
                $('#create_product').modal('show');
            });
        });
    </script>
@endpush
