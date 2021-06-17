<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <div class="container-fluid">
        @yield('content')
    </div>
</body>
<script src="{{ asset('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

</html>