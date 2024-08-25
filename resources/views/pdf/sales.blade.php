<!-- resources/views/pdf/sales.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Vendas</title>
    <style>
        /* Adicione estilos aqui para formatar o PDF */
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
        <p>Gerado em: {{ date('d/m/Y') }}</p>
        <p>Unidades vendidas:
            {{ $sales->sum(function ($sale) {
                return $sale->products->sum('pivot.quantity');
            }) }}
        </p>
        <p>Total de vendas: R$ {{ number_format($sales->sum('total_amount'), 2, ',', '.') }}</p>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Data</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->seller->name }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($sale->total_amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
