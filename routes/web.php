<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Category;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/all', [BookController::class, 'allBooks'])->name('books.all');

// Route Dashboard (User)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();

    $bookCount = Book::where('user_id', $user->id)->count();
    $categoryCount = Category::count();
    $favoriteCount = 0; // Ganti nanti jika ada fitur favorit

    return view('dashboard', compact('bookCount', 'categoryCount', 'favoriteCount'));
})->name('dashboard');

// Route Khusus Authenticated + Verified Users
Route::middleware(['auth', 'verified'])->group(function () {

    // Route Buku oleh User
    Route::resource('books', BookController::class)->except(['edit', 'update']);

    // Route tambahan
    Route::get('/phpinfo', function () {
        phpinfo();
    });

    // Admin Only
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
        Route::post('/books/store', [AdminController::class, 'storeBook'])->name('admin.books.store');
        Route::delete('/books/{book}', [AdminController::class, 'deleteBook'])->name('admin.books.destroy');

        // Optional: tambah route untuk pending/approve/reject
        Route::get('/books/pending', [AdminController::class, 'pendingBooks'])->name('admin.books.pending');
        Route::post('/books/{book}/approve', [AdminController::class, 'approveBook'])->name('admin.books.approve');
        Route::post('/books/{book}/reject', [AdminController::class, 'rejectBook'])->name('admin.books.reject');
    });
});

require __DIR__.'/auth.php';

