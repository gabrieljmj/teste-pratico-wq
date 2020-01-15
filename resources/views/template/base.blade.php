<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('app.lang')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google_maps_api_key" content="{{ config('google_maps.api_key') }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @include('template.routes')

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('template.header')

    <main class="container pt-4" id="app">
        @yield('content')
    </main>

    @include('template.footer')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
