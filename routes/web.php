<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Book;
use App\Models\Category;

// Beri nama route home untuk halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/all', [BookController::class, 'allBooks'])->name('books.all');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // User 
    Route::resource('books', BookController::class)->except(['edit', 'update']);
    Route::get('/phpinfo', function () {
    phpinfo();
});

    // Admin routesssss
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Jangan beri nama route 'home' lagi di sini karena sudah ada
        Route::get('/', [HomeController::class, 'index'])->name('admin.home'); // contoh nama route baru
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
        Route::post('/books/store', [AdminController::class, 'storeBook'])->name('admin.books.store');
        Route::delete('/books/{book}', [AdminController::class, 'deleteBook'])->name('admin.books.destroy');
    });
    Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();

    $bookCount = Book::where('user_id', $user->id)->count();
    $categoryCount = Category::count();
    $favoriteCount = 0; // Contoh placeholder

    return view('dashboard', compact('bookCount', 'categoryCount', 'favoriteCount'));
})->name('dashboard');
});

require __DIR__.'/auth.php';
