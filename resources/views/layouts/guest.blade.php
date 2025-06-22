@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <!-- Tambah meta atau link lain di sini -->
</head>
<body class="bg-gray-50">
    @include('layouts.navigation')

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
