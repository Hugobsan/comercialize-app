{{-- 
Componente de tabela para exibição de vendas 
$sales: coleção de vendas
--}}

<div class="table-responsive">
    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Data</th>
                <th scope="col">Total</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <th scope="row">{{ $sale->id }}</th>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>R$ {{ $sale->total_amount }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Ver detalhes da venda">
                            Detalhes
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhuma venda encontrada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

