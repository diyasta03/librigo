{{-- resources/views/books/index.blade.php --}}

@extends('layouts.app') {{-- Menggunakan layout aplikasi utama (bukan guest) --}}

@section('title', 'Buku Saya')

@section('header') {{-- Tambahkan section header jika app.blade.php menggunakannya --}}
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Daftar Buku Saya') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                {{-- Header daftar buku dan tombol tambah --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Buku</h3>
                    <a href="{{ route('books.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Tambah Buku
                    </a>
                </div>

                {{-- Notifikasi sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tabel daftar buku --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judul
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status {{-- <--- KOLOM BARU --}}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($books as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img src="{{ env('SUPABASE_STORAGE_URL') . '/' . $book->cover_path }}" alt="{{ $book->title }}" class="h-10 w-10 rounded-full object-cover">                                            
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($book->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $book->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"> {{-- <--- KOLOM BARU --}}
                                        <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                            @if($book->status === 'approved') text-green-900 
                                            @elseif($book->status === 'pending') text-yellow-900 
                                            @else text-red-900 @endif">
                                            <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full 
                                                @if($book->status === 'approved') bg-green-200 
                                                @elseif($book->status === 'pending') bg-yellow-200 
                                                @else bg-red-200 @endif"></span>
                                            <span class="relative">{{ ucfirst($book->status) }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                        <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900">
                                            Baca
                                        </a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500"> {{-- <--- UBAH COLSPAN --}}
                                        Tidak ada buku yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection