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
            <div class="topo">
                <h1>Vendas</h1>
                <button class="btn btn-danger text-white p-2">
                    <i class="fas fa-file-pdf"></i> Exportar relatório
                </button>
            </div>
            <div>
                <form action="{{ route('sales.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control" name="search" placeholder="Pesquise por cliente, vendedor, produto ou categoria"
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            @include('sales.components.table', ['sales' => $sales])
            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $sales->links() }}
            </div>
        </div>
    
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush