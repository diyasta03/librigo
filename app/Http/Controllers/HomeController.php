<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Tidak selalu diperlukan di HomeController

class HomeController extends Controller
{
    public function index()
    {
        // Untuk halaman utama (home.blade.php)
        // Hanya tampilkan buku terbaru yang sudah disetujui (approved)
        $latestBooks = Book::with('category')
                          ->where('status', 'approved') // <--- TAMBAHKAN FILTER INI
                          ->latest()
                          ->take(6)
                          ->get();
        
        // Hanya tampilkan kategori yang memiliki buku approved (melalui withCount)
        $categories = Category::withCount(['books' => function($query) {
                                $query->where('status', 'approved'); // <--- PASTIKAN FILTER INI JUGA ADA DI withCount
                            }])
                            ->orderBy('books_count', 'desc')
                            ->take(8)
                            ->get();

        return view('home', compact('latestBooks', 'categories'));
    }

    // Jika Anda memiliki metode userDashboard, pastikan juga memfilter status jika diperlukan
    // public function userDashboard(){
    //     // ... logic Anda ...
    //     $books = Book::with('category')
    //                 ->where('user_id', Auth::id())
    //                 ->where('status', 'approved') // <--- TAMBAHKAN FILTER INI JIKA COCOK
    //                 ->latest()
    //                 ->get();
    //     return view('dashboard', compact('books', ...));
    // }
}