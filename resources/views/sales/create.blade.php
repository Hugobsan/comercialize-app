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
    <div class="container">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="seller">Vendedor</label>
                <select class="form-control" id="seller" name="seller">
                    <option value="">Selecione um vendedor</option>
                    $PLACEHOLDER${{-- Add options dynamically --}}
                </select>
                @error('seller')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="customer">Cliente</label>
                <select class="form-control" id="customer" name="customer">
                    <option value="">Selecione um cliente</option>
                    $PLACEHOLDER${{-- Add options dynamically --}}
                </select>
                @error('customer')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart_products as $cart_product)
                        <tr>
                            <td>{{ $cart_product[0]->name }}</td>
                            <td>{{ $cart_product[1] }}</td>
                            <td>{{ $cart_product[2] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <p>Total de produtos: {{ count($cart_products) }}</p>
                <p>Soma total: $PLACEHOLDER${{-- Calculate the total sum dynamically --}}</p>
            </div>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                Adicionar Produto
            </button>

            <button type="submit" class="btn btn-success">Finalizar Venda</button>
        </form>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Produto</label>
                        <select class="form-control" id="product" name="product">
                            <option value="">Selecione um produto</option>
                            $PLACEHOLDER${{-- Add options dynamically --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantidade</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="addProductBtn">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
