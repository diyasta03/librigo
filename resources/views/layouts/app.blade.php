<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Perpustakaan Online') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
      body {
        margin: 0;
        font-family: 'Nunito', sans-serif;
        background-color: #f9fafb; /* abu terang */
        color: #1a202c; /* teks gelap */
      }

      .min-h-screen {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }

      header {
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      }

      .header-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
      }

      main {
        flex-grow: 1;
        max-width: 1120px;
        margin: 1rem auto;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        padding: 2rem 1rem;
      }

      @media (min-width: 640px) {
        .header-container, main {
          padding-left: 1.5rem;
          padding-right: 1.5rem;
        }
      }

      @media (min-width: 1024px) {
        .header-container, main {
          padding-left: 2rem;
          padding-right: 2rem;
        }
      }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Navigasi (bisa berupa komponen atau include biasa) -->
        @include('layouts.navigation')
        {{-- Atau jika menggunakan komponen: --}}
        {{-- <x-nav /> --}}

        <!-- Judul Halaman -->
        @if (isset($header))
        <header>
            <div class="header-container">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Isi Konten Halaman -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
