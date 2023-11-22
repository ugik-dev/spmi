<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'SPMI Smart System') }}</title>
    <!-- Favicons -->
    @include('partials.favicons') <!-- Partial for favicon links -->

    <!-- FontAwesome -->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-gradient-primary">

    <div class="container">
        @yield('auth')
    </div>

    <!-- App JS -->
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
