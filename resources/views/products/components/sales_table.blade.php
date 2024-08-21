{{-- 
Componente de tabela para exibição de vendas 
$product: produto a ser feito relatório
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
            @forelse ($product->salesProducts->reverse() as $sp)
                <tr>
                    <th scope="row">{{ $sp->id }}</th>
                    <td>{{ $sp->sale->customer->name }}</td>
                    <td>{{ $sp->sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>R$ {{ $sp->formatted_total_price }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sp->sale->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Ver detalhes da venda">
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

