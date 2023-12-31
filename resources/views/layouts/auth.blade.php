<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.2/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ mix('dist/main.css') }}">

    <script src="{{ asset('assets/js/jquery.js') }}"></script>

    @stack('style')
</head>
<body>
    @yield('content')

    <script src="/js/lang.js"></script>

    <script src="{{ asset('assets/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ mix('dist/app.js') }}"></script>

    @stack('script')
</body>
</html>
