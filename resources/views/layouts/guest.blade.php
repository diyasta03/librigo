<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Perpustakaan Digital')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body class="bg-gray-50">
    @include('layouts.navigation')

    @yield('content')

    </body>
</html>