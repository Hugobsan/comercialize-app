<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Número de itens no carrinho -->
    <meta name="cart-items" content="{{ count(session('cart', [])) }}">

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/latest/normalize.css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- FontAwesome-->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">

    @stack('styles')
</head>

<body>
    @include('layouts.components.navbar')
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // DataTable
            $('.data-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
                }
            });

            //Tooltip
            $(function() {
                $('[data-bs-toggle="tooltip"]').tooltip()
            });

            // Adicionando badge no botão sell
            if ($('meta[name="cart-items"]').attr('content') > 0) {
                $('.nav-sell-button').append('<span class="badge bg-danger">' + $('meta[name="cart-items"]').attr('content') + '</span>');
            }
        });
    </script>
    @stack('scripts')

</body>

</html>
