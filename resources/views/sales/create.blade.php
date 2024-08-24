@extends('layouts.app')

@section('title', 'Finalizar venda')

@push('styles')
    <style>
        .paginator {
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container my-3">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-12 col-md-6">
                    <label for="seller">Vendedor</label>
                    <select class="form-control" id="seller" name="seller" required>
                        <option value="">Selecione um vendedor</option>
                        @foreach ($sellers as $seller)
                            <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                        @endforeach
                    </select>
                    @error('seller')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-12 col-md-6">
                    <label for="customer">Cliente</label>
                    <select class="form-control" id="customer" name="customer" required>
                        <option value="">Selecione um cliente</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="table-responsive my-3 p-3 bg-white rounded shadow">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Preço Un.</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart_products as $cart_product)
                            <tr>
                                <td>{{ $cart_product['product']->name }}</td>
                                <td>{{ $cart_product['quantity'] }}</td>
                                <td>R$ {{ $cart_product['product']->price }}</td>
                                <td>
                                    {{-- Acrescentar item --}}
                                    <a class="btn btn-success btn-plus" href="{{ route('cart.add', ['product' => $cart_product['product']->id]) }}" data-stock="{{ $cart_product['quantity'] }}">
                                        <i class="fas fa-plus"></i>
                                    </a>

                                    {{-- Diminuir item --}}
                                    <a class="btn btn-warning btn-minus" href="{{ route('cart.decrease', ['product' => $cart_product['product']->id]) }}" data-quantity="{{ $cart_product['quantity'] }}">
                                        <i class="fas fa-minus"></i>
                                    </a>

                                    {{-- Remover item --}}
                                    <a class="btn btn-danger" href="{{ route('cart.remove', ['product' => $cart_product['product']->id]) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right py-3">
                    <p>Quant. de Produtos: {{ count($cart_products) }}</p>
                    <p class="h3">Total: R$ <span>{{ number_format($total, 2, ',', '.') }}</span></p>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    Adicionar Produto
                </button>

                <button type="submit" class="btn btn-success">Finalizar Venda</button>
        </form>
    </div>

    <!-- Add Product Modal -->
    @include('sales.components.add-product', ['products' => $products])
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            //Removendo botao de diminuir caso a quantidade seja 1
            $('.btn-minus').each(function() {
                if ($(this).data('quantity') == 1) {
                    $(this).remove();
                }
            });

            //Desabilitando botao de adicionar caso o estoque seja 0
            $('.btn-plus').each(function() {
                if ($(this).data('stock') == 0) {
                    $(this).prop('disabled', true);
                }
            });
        });
    </script>
@endpush
