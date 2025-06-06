<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $books = Book::with(['user', 'category'])->latest()->get();
        return view('admin.dashboard', compact('books'));
    }

    public function createBook()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required|mimes:pdf|max:10000',
        ]);

        $coverPath = $request->file('cover')->store('covers', 'public');
        $filePath = $request->file('file')->store('books', 'public');

        Book::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'cover_path' => $coverPath,
            'file_path' => $filePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function deleteBook(Book $book)
    {
        Storage::disk('public')->delete($book->cover_path);
        Storage::disk('public')->delete($book->file_path);
        
        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }
}