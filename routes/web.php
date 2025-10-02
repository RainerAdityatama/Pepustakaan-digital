<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserbooksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Userdenda;
use App\Http\Controllers\Userpeminjaman;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin')->group(function () {
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });

});

Route::middleware('auth', 'role:pustakawan')->group(function () {
    
    Route::prefix('pustakawan')->name('pustakawan.')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('books', BooksController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('denda', DendaController::class);


        Route::get('/books/{book}/stocks', [BooksController::class, 'manageStock'])->name('stocks.manage');

        Route::post('/books/{book}/stocks', [BooksController::class, 'addStock'])->name('stocks.add');

        Route::delete('/stocks/{stock}', [BooksController::class, 'removeStock'])->name('stocks.remove');

    });

});

Route::middleware('auth', 'role:user')->group(function () {
    
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('books_user', UserbooksController::class);
        Route::resource('peminjaman_user', Userpeminjaman::class);
        Route::resource('denda_user', Userdenda::class);
    });

    Route::post('/user/books_user/{book}/pinjam', [UserbooksController::class, 'pinjam'])
    ->name('user.books_user.pinjam');

});

require __DIR__ . '/auth.php';
