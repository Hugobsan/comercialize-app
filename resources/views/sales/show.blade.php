@extends('layouts.app')

@section('title', 'Vendas')

@push('styles')
    <style>
        .paginator {
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-content-center justify-content-center">
            <div class="container my-3 p-3 bg-white rounded shadow row">
                <div class="col-11">
                    <h1>Venda nº {{ $sale->id }}</h1>
                    <p>
                        <strong>Cliente:</strong> {{ $sale->customer->name }}<br>
                        <strong>Vendedor:</strong> {{ $sale->seller->name }}<br>
                        <strong>Data:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}<br>
                        <strong>Total:</strong> R$ {{ $sale->total_amount }}<br>
                        <strong>Quant. de itens comprados: </strong> {{ $sale->total_quantity }}
                    </p>
                </div>
                <div class="col-1 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('sales.index') }}">Voltar</a></li>
                        @can('delete', $sale)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="btn-danger">
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item">Excluir</button>
                                </form>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Preço Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through the sales items --}}
                        @forelse ($sale->saleProducts as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->formatted_price }}</td>
                                <td>{{ $item->formatted_total_price }}</td>
                                <td>
                                    {{-- Remover item --}}
                                    <form action="{{ route('sales.remove-item', $item->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Nenhum item encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
@endsection
