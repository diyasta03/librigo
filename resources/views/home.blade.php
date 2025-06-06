    @extends('layouts.guest')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-bold text-white sm:text-5xl md:text-6xl">
                            <span class="block">Perpustakaan Digital</span>
                            <span class="block text-indigo-200">Modern</span>
                        </h1>
                        <p class="mt-3 text-base text-indigo-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Temukan ribuan buku berkualitas dari berbagai kategori. Baca gratis kapan saja, di mana saja.
                        </p>
                        <div class="mt-8 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            @auth
                                <a href="{{ route('books.index') }}" class="px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 transition-colors duration-200 md:py-4 md:text-lg md:px-8">
                                    Mulai Membaca
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 transition-colors duration-200 md:py-4 md:text-lg md:px-8">
                                    Daftar Sekarang
                                </a>
                            @endauth
                            <a href="#recent-books" class="px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-700 hover:bg-indigo-800 transition-colors duration-200 md:py-4 md:text-lg md:px-8">
                                Jelajahi Buku
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1551029506-0807df4e2031?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Library" loading="lazy">
        </div>
    </div>

    <!-- Recent Books Section -->
    <div id="recent-books" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                    Buku Terbaru
                </h2>
                <p class="mt-3 max-w-2xl text-lg text-gray-500 mx-auto">
                    Temukan buku-buku terbaru yang tersedia di perpustakaan kami
                </p>
            </div>

           <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @foreach($latestBooks as $book)
        <div class="relative group bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
            {{-- Cover Buku --}}
            <div class="relative w-full" style="padding-top: 150%; background-color: #f3f4f6;">
               <img
    src="{{ env('SUPABASE_STORAGE_URL') . '/' . $book->cover_path }}"
    alt="Cover {{ $book->title }}"
    class="absolute inset-0 w-full h-full object-cover object-center transition duration-300 group-hover:opacity-90"
    loading="lazy"
/>

                {{-- Overlay Tombol Baca --}}
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <a href="{{ route('books.show', $book) }}"
                       class="text-white text-sm font-semibold bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 transition">
                        Baca
                    </a>
                </div>
            </div>

            {{-- Informasi Buku --}}
            <div class="p-4">
                <h3 class="text-md font-semibold text-gray-900 truncate" title="{{ $book->title }}">
                    {{ $book->title }}
                </h3>
                <p class="text-sm text-gray-600 mt-1 truncate">
                    Penerbit: {{ $book->publisher ?? 'Tidak diketahui' }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Kategori: {{ $book->category->name }}
                </p>
            </div>
        </div>
    @endforeach
</div>

            <div class="mt-12 text-center">
                <a href="{{ route('books.all') }}"  class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Lihat Semua Buku
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                    Kategori Buku
                </h2>
                <p class="mt-3 max-w-2xl text-lg text-gray-500 mx-auto">
                    Jelajahi buku berdasarkan kategori favorit Anda
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($categories as $category)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->books_count }} buku tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4">
                        <a href="{{ auth()->check() ? route('books.index') : route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Lihat semua<span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-indigo-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">
                <span class="block">Siap memulai petualangan membaca?</span>
                <span class="block">Daftar sekarang secara gratis.</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Akses ribuan buku berkualitas dari berbagai genre tanpa biaya.
            </p>
            <div class="mt-8">
                @guest
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 transition-colors duration-200">
                    Daftar Sekarang
                </a>
                @endguest
                @auth
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 transition-colors duration-200">
                    Mulai Membaca
                </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection