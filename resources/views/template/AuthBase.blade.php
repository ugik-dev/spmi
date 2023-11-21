<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | SPMI Smart System</title>

    <!-- Favicons -->
    @include('partials.favicons') <!-- Partial for favicon links -->

    <!-- FontAwesome -->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Vendor CSS (Bootstrap, DataTables, etc.) -->
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">

    <!-- App CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="bg-gradient-primary">

    <div class="container">
        @yield('auth')
    </div>

    <!-- Vendor JS (jQuery, Bootstrap, etc.) -->
    <script src="{{ mix('js/vendor.js') }}"></script>

    <!-- App JS -->
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
