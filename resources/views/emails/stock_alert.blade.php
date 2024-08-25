<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta de Estoque Baixo</title>
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
            color: #dc3545;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .button {
            display: inline-block;
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

        .danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Alerta de Estoque Baixo</h1>
            <p>Olá,</p>
            <p>Estamos enviando este e-mail para informar que alguns produtos estão com o estoque abaixo do limite ideal. Por favor, verifique os detalhes abaixo e tome as ações necessárias.</p>
        </div>
        <div class="section">
            <h2>Produtos com Estoque Baixo</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Quantidade Atual</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="button">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="danger">Nenhum produto com estoque baixo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="section">
            <p>Obrigado por sua atenção.</p>
        </div>
    </div>
</body>

</html>
