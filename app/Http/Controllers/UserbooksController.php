<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stok;
use App\Models\Books;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserbooksController extends Controller
{
    public function index()
    {
        $books = Books::all();

        return view('user.books_user.index', [
            'books' => $books
        ]);
    }

    public function pinjam(Request $request, Books $book)
    {
        try {
            // Memulai database transaction
            DB::transaction(function () use ($book) {

                $stock = Stok::where('book_id', $book->id)
                    ->where('status', 'tersedia')
                    ->inRandomOrder()
                    ->lockForUpdate()
                    ->first();

                if (!$stock) {
                    return redirect()->back()->with('error', 'Maaf, semua stok buku ini sedang dipinjam.');
                }

                Peminjaman::create([
                    'stock_id'             => $stock->id,
                    'user_id'              => Auth::id(),
                    'book_id'              => $book->id,
                    'tanggal_peminjaman'   => now(),
                    'tanggal_pengembalian_seharusnya' => now()->addDays(7),
                ]);

                $stock->update(['status' => 'tidak_tersedia']);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('user.books_user.index')->with('success', 'Buku berhasil dipinjam!');
    }
}
