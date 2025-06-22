@extends('layouts.app') {{-- Menggunakan layout aplikasi utama --}}

@section('title', 'Buku Menunggu Persetujuan') {{-- Judul halaman untuk tag <title> --}}

@section('header') {{-- Section untuk konten header halaman --}}
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Buku Menunggu Persetujuan') }}
    </h2>
@endsection

@section('content') {{-- Section untuk konten utama halaman --}}
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Buku Menunggu Persetujuan Admin</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex justify-start">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            &larr; Kembali ke Dashboard Admin
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Judul Buku
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Uploader
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tanggal Upload
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingBooks as $book)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $book->title }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $book->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $book->category->name ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $book->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Lihat Detail</a>
                            
                            <form action="{{ route('admin.books.approve', $book) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Setujui</button>
                            </form>
                            <form action="{{ route('admin.books.reject', $book) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Tolak</button>
                            </form>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium" onclick="return confirm('Anda yakin ingin menghapus buku ini?');">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            Tidak ada buku yang menunggu persetujuan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection