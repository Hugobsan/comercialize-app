<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Vendas de Produto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            margin-bottom: 20px;
        }

        header h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #b1b1b1;
        }

        tr:nth-child(even) {
            background-color: #dbdbdb;
        }
    </style>
</head>

<body>
    <header>
        <h1>Relatório de Vendas</h1>
        <h3>Produto: {{ $product->name }}</h3>
        <p>Gerado em: {{ date('d/m/Y') }}</p>
        <p>Unidades vendidas:
            {{ $product->sales->sum(function ($sale) {
                return $sale->products->sum('pivot.quantity');
            }) }}
        </p>
        <p>Total de vendas: R$
            {{ number_format($product->sales->sum(function ($sale) use ($product) {
                return $sale->products->where('id', $product->id)->sum(function ($product) {
                    return $product->pivot->quantity * $product->pivot->price;
                });
            }), 2, ',', '.') }}
        </p>
    </header>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Data</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product->sales as $sale)
                <tr>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->seller->name }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($sale->products->where('id', $product->id)->sum(function ($product) {
                        return $product->pivot->quantity * $product->pivot->price;
                    }), 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

