<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestBooks = Book::with('category')
                          ->latest()
                          ->take(6)
                          ->get();
        
        $categories = Category::withCount('books')
                            ->orderBy('books_count', 'desc')
                            ->take(8)
                            ->get();

        return view('home', compact('latestBooks', 'categories'));
    }
}