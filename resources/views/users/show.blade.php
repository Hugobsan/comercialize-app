@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="container my-3 p-3 bg-white rounded shadow row">
                <div class="col-11">
                    <h1>{{ $user->name }}</h1>
                    <p>
                        <strong>Tipo de usuário:</strong> <span class="text-capitalize">{{ trans('default.' . $user->role) }}</span><br>
                        <strong>E-mail:</strong> {{ $user->email }}<br>
                        <strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}<br>

                        @if ($user->role == 'seller')
                            <br>
                            <strong>Total de vendas:</strong> {{ $user->sales->count() }}<br>
                            <strong>Total vendido:</strong> R$ {{ number_format($user->sales->sum('total_amount') ?? 0, 2, ',', '.') }}<br>
                        @endif

                        @if ($user->role == 'customer')
                            <br>
                            <strong>Total de compras:</strong> {{ $user->sales->count() }}<br>
                            <strong>Total gasto:</strong> R$ {{ number_format($user->sales->sum('total_amount') ?? 0, 2, ',', '.') }}<br>
                        @endif
                    </p>
                </div>
                <div class="col-1 dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Voltar</a></li>
                        @can('delete', $user)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Excluir</button>
                                </form>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>

            @if ($user->role != 'admin')
                <!-- Adicionando Abas para o Gráfico e a Tabela -->
                <div class="container my-3 p-3 bg-white rounded shadow">
                    <ul class="nav nav-tabs" id="salesTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="true">Gráfico</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">Tabela</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="salesTabContent">
                        <!-- Aba Gráfico -->
                        <div class="tab-pane fade show active" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                            <canvas id="salesChart"></canvas>
                        </div>
                        <!-- Aba Tabela -->
                        <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table-tab">
                            @include('sales.components.table', ['sales' => $user->sales, 'hasDataTable' => true])
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var salesData = @json($salesData);

        createChart('salesChart', salesData, 'Vendas');
    </script>
@endpush
