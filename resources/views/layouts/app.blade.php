<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Arjuno Travel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
        <!-- resources/views/layouts/app.blade.php -->
        <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/8262/8262475.png" />

    </head>
    <body>
        @include('components.header')
    
    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Add your JavaScript scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>