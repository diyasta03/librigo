<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category; // Tetap di-import, tapi tidak dipakai langsung
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Hanya jalankan query Books yang sangat minimal
        $latestBooks = Book::take(1)->get(); // Ambil hanya 1 buku, tanpa eager load 'category'

        // Komen sepenuhnya query Categories
        $categories = collect(); // Kirim koleksi kosong ke view

        return view('home', compact('latestBooks', 'categories'));
    }
}