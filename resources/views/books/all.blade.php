@extends('layouts.guest')

@section('title', 'Daftar Buku')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h1 class="text-3xl font-bold mb-8 text-center">Katalog Buku</h1>

        @forelse ($categories as $category)
            <section class="mb-12">
                <h2 class="text-2xl font-semibold mb-6 border-b border-gray-300 pb-2">
                    {{ $category->name }}
                </h2>

                @if($category->books->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($category->books as $book)
                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer"
                                onclick="window.location='{{ route('books.show', $book->id) }}'">

                                {{-- Cover Buku --}}
                                <div class="relative" style="padding-top: 133.33%; overflow: hidden;">
                                    <img 
src="{{ env('SUPABASE_STORAGE_URL') . '/' . $book->cover_path }}"                                        alt="Cover {{ $book->title }}"
                                        class="absolute top-0 left-0 w-full h-full object-cover"
                                    />
                                </div>

                                {{-- Info Buku --}}
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-1 truncate" title="{{ $book->title }}">
                                        {{ $book->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-3">
                                        {{ Str::limit($book->description, 100) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada buku di kategori ini.</p>
                @endif
            </section>
        @empty
            <p class="text-center text-gray-500">Kategori buku belum tersedia.</p>
        @endforelse

    </div>
</div>
@endsection
