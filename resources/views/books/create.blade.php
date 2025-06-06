@extends('layouts.guest')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-8">
                <h1 class="text-2xl font-semibold mb-6">Tambah Buku Baru</h1>
                @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <strong>Terjadi kesalahan saat upload file:</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            placeholder="Masukkan judul buku"
                            required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            placeholder="Deskripsi singkat buku"
                            required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        ></textarea>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select
                            name="category_id"
                            id="category_id"
                            required
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                        >
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="cover" class="block text-sm font-medium text-gray-700">Cover Buku</label>
                        <input
                            type="file"
                            name="cover"
                            id="cover"
                            accept="image/*"
                            required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700">File Buku (PDF)</label>
                        <input
                            type="file"
                            name="file"
                            id="file"
                            accept=".pdf"
                            required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                        >
                            Simpan Buku
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
