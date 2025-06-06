<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // <--- TAMBAHKAN BARIS INI
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            $books = Book::with(['user', 'category'])->latest()->get();
        } else {
            $books = Book::with(['user', 'category'])
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->get();
        }
        
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    

       public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'file' => 'required|mimes:pdf|max:20000',
    ]);

    $projectId = env('SUPABASE_PROJECT_ID');
    $bucket = env('SUPABASE_STORAGE_BUCKET', 'librigo-books');
    $token = env('SUPABASE_SERVICE_ROLE_KEY');

    $coverName = 'book_covers/' . Str::random(40) . '.' . $request->file('cover')->getClientOriginalExtension();
    $fileName = 'book_pdfs/' . Str::random(40) . '.' . $request->file('file')->getClientOriginalExtension();

    // Upload cover
    $coverResponse = Http::withToken($token)
        ->attach('file', file_get_contents($request->file('cover')), $coverName)
        ->post("https://$projectId.supabase.co/storage/v1/object/$bucket/$coverName");

    if (!$coverResponse->successful()) {
        Log::error("Cover upload failed: " . $coverResponse->body());
        return back()->withErrors(['cover' => 'Gagal mengunggah cover: ' . $coverResponse->body()]);
    }

    // Upload file PDF
    $fileResponse = Http::withToken($token)
        ->attach('file', file_get_contents($request->file('file')), $fileName)
        ->post("https://$projectId.supabase.co/storage/v1/object/$bucket/$fileName");

    if (!$fileResponse->successful()) {
        Log::error("PDF upload failed: " . $fileResponse->body());
        return back()->withErrors(['file' => 'Gagal mengunggah file PDF: ' . $fileResponse->body()]);
    }

    // Simpan ke database
    Book::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category_id' => $validated['category_id'],
        'cover_path' => $coverName,
        'file_path' => $fileName,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
}



    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function destroy(Book $book)
    {
        // Hanya admin atau pemilik buku yang bisa menghapus
        if(!auth()->user()->isAdmin() && $book->user_id !== auth()->id()) {
            abort(403);
        }

        // --- PERUBAHAN UTAMA DI SINI: Hapus dari 's3' disk ---
        Storage::disk('s3')->delete($book->cover_path);
        Storage::disk('s3')->delete($book->file_path);
        
        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }
     public function allBooks()
    {
        // Mengambil semua kategori beserta buku-buku terkait (eager loading)
        $categories = Category::with('books')->get();

        // Memanggil view 'all' dan mengirim data kategori
        return view('books.all', compact('categories'));
    }
}