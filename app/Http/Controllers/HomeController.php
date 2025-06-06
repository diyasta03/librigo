<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Category; // Tetap di-import
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestBooks = Book::with('category')
                          ->latest()
                          ->take(6)
                          ->get();

        $categories = collect(); // Ubah ini menjadi koleksi kosong sementara

        return view('home', compact('latestBooks', 'categories'));
    }
}