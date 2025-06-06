@extends('layouts.guest')

@section('title', 'Dashboard User')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6">Selamat datang, {{ auth()->user()->name }}!</h1>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-6 bg-blue-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-2">Buku yang Anda Upload</h2>
                    <p class="text-4xl font-bold">{{ $bookCount }}</p>
                </div>

                <div class="p-6 bg-green-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-2">Total Kategori Buku</h2>
                    <p class="text-4xl font-bold">{{ $categoryCount }}</p>
                </div>

                <div class="p-6 bg-yellow-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-2">Buku Favorit (Contoh)</h2>
                    <p class="text-4xl font-bold">{{ $favoriteCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
