<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimento pela Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header img {
            max-width: 150px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            margin-bottom: 10px;
        }

        .section p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .button {
            display: inline-block;
            margin-top: 5px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Obrigado {{ $sale->customer->name }} pela sua compra!</h1>
            <p>Nós da {{ env('APP_NAME') }} agradecemos por comprar conosco. Abaixo estão os detalhes da sua compra.</p>
        </div>
        <div class="section">
            <p><strong>Vendedor:</strong> {{ $sale->seller->name }}</p>
            <p><strong>Data:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> R$ {{ $sale->formatted_total_amount }}</p>
            <p><strong>Quantidade de Itens Comprados:</strong> {{ $sale->total_quantity }}</p>
        </div>
        <div class="section">
            <h2>Detalhes da Compra</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Preço Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sale->saleProducts as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>R$ {{ $item->formatted_price }}</td>
                            <td>R$ {{ $item->formatted_total_price }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum item encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="section" style="text-align: center;">
            <p>Obrigado por comprar conosco! Se precisar de mais informações, clique no botão abaixo para visualizar os detalhes da sua compra.</p>
            <a href="{{ env('APP_URL') . '/sales/' . $sale->id }}" class="button">Ver Detalhes da Compra</a>
        </div>
    </div>
</body>

</html>
