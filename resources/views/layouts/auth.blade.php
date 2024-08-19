<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome-->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        .filler-login {
            background-image: url("{{ asset('imgs/img_login.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="content row">
        <div class="d-none d-sm-none d-md-flex col-md-6 col-lg-8 col-xl-8 filler-login">
            <div class="brand-filler">
                <i class="fa-solid fa-shop"></i>
                <span class="brand">Comercialize</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 data-login">
            <div class="brand-login">
                <i class="fa-solid fa-shop"></i>
                <span class="brand">Comercialize</span>
            </div>
            <div class="form-content">
                @yield('content')
            </div>
        </div>
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        const passwordInput = document.querySelector("#password");
        const eye = document.querySelector("#eye");

        eye.addEventListener("click", togglePassword);

        function togglePassword() {
            if (passwordInput.type == "password") {
                passwordInput.type = "text"
                eye.classList.remove("fa-eye")
                eye.classList.add("fa-eye-slash")
            } else {
                passwordInput.type = "password"
                eye.classList.remove("fa-eye-slash")
                eye.classList.add("fa-eye")
            }
        }
    </script>
    @yield('script')

</body>

</html>
