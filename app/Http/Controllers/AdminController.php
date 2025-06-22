<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Attributes\Middleware; // ⬅️ Tambahkan ini!

#[Middleware('admin')] // ⬅️ Gantikan __construct() lama
class AdminController extends Controller
{
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
            'file' => 'required|mimes:pdf|max:20000',
        ]);

        $projectId = env('SUPABASE_PROJECT_ID');
        $bucket = env('SUPABASE_STORAGE_BUCKET', 'librigo-books');
        $token = env('SUPABASE_SERVICE_ROLE_KEY');

        $coverName = 'book_covers/' . Str::random(40) . '.' . $request->file('cover')->getClientOriginalExtension();
        $fileName = 'book_pdfs/' . Str::random(40) . '.' . $request->file('file')->getClientOriginalExtension();

        $coverResponse = Http::withToken($token)
            ->attach('file', file_get_contents($request->file('cover')), $coverName)
            ->post("https://$projectId.supabase.co/storage/v1/object/$bucket/$coverName");

        if (!$coverResponse->successful()) {
            Log::error("Admin: Cover upload failed: " . $coverResponse->body());
            return back()->withErrors(['cover' => 'Gagal mengunggah cover: ' . $coverResponse->body()]);
        }

        $fileResponse = Http::withToken($token)
            ->attach('file', file_get_contents($request->file('file')), $fileName)
            ->post("https://$projectId.supabase.co/storage/v1/object/$bucket/$fileName");

        if (!$fileResponse->successful()) {
            Log::error("Admin: PDF upload failed: " . $fileResponse->body());
            return back()->withErrors(['file' => 'Gagal mengunggah file PDF: ' . $fileResponse->body()]);
        }

        Book::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'cover_path' => $coverName,
            'file_path' => $fileName,
            'user_id' => auth()->id(),
            'status' => 'approved',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function deleteBook(Book $book)
    {
        Storage::disk('s3')->delete($book->cover_path);
        Storage::disk('s3')->delete($book->file_path);

        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus!');
    }

    public function pendingBooks()
    {
        $pendingBooks = Book::with(['user', 'category'])
                            ->where('status', 'pending')
                            ->latest()
                            ->get();
        return view('admin.books.pending', compact('pendingBooks'));
    }

    public function approveBook(Book $book)
    {
        $book->status = 'approved';
        $book->save();

        return back()->with('success', 'Buku berhasil disetujui!');
    }

    public function rejectBook(Book $book)
    {
        $book->status = 'rejected';
        $book->save();

        return back()->with('success', 'Buku berhasil ditolak!');
    }
}
