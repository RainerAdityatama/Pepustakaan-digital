<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stok;
use App\Models\User;
use App\Models\Books;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::all();

        return view('pustakawan.peminjaman.index', [
            'peminjamans' => $peminjamans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Books::with('stock')->get();
        $users = User::with('roles')->role(['user'])->get();

        return view('pustakawan.peminjaman.add', [
            'books' => $books,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Aturan validasi (Sudah benar)
        $validatedData = $request->validate([
            'stock_id' => 'required|exists:stoks,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_peminjaman' => 'required|date',
        ]);

        try {
            // Memulai transaksi database (Sudah benar)
            DB::transaction(function () use ($validatedData) {

                // 2. Mengambil data stok dan menguncinya (Sudah benar)
                $stock = Stok::lockForUpdate()->find($validatedData['stock_id']);

                // 3. Pengecekan ketersediaan (Sudah benar)
                if ($stock->status !== 'tersedia') {
                    throw new Exception('Buku dengan stok ini sedang tidak tersedia atau sudah dipinjam.');
                }

                // 4. Membuat record peminjaman baru
                // Ini akan mengambil book_id secara otomatis dari $stock
                Peminjaman::create([
                    'stock_id' => $stock->id,
                    'user_id' => $validatedData['user_id'],
                    'book_id' => $stock->book_id, // Kunci utamanya di sini
                    'tanggal_peminjaman' => $validatedData['tanggal_peminjaman'],
                    'tanggal_pengembalian_seharusnya' => now()->addDays(7),
                ]);

                // 5. Update status stok (Sudah benar)
                $stock->update(['status' => 'tidak_tersedia']);
            });
        } catch (Exception $e) {
            // Mencatat error dan mengembalikan dengan pesan (Sudah benar)
            Log::error('Gagal membuat peminjaman: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        // Jika berhasil, redirect dengan pesan sukses (Sudah benar)
        return redirect()->route('pustakawan.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::FindOrfail($id);

        $tanggal_seharusnya = $peminjaman->tanggal_pengembalian_seharusnya;

        $now = now();

        // cara pengurangan di tanggal untuk menghitung denda
        $selisih_hari = $tanggal_seharusnya->diffInDays($now, false);
        $denda = max(0, $selisih_hari);
        $dendaPerHari = 2000;
        $totalDenda = $denda * $dendaPerHari;

        if ($now > $peminjaman->tanggal_pengembalian_seharusnya) {
            $peminjaman->update([
                'tanggal_pengembalian' => $now,
                'status' => 'terlambat',
                'denda' => $totalDenda
            ]);
        } else {
            $peminjaman->update([
                'tanggal_pengembalian' => $now,
                'status' => 'dikembalikan',
                'denda' => 0
            ]);
        }

        $stock = Stok::find($peminjaman->stock_id);

        if ($stock) {
            $stock->update(['status' => 'tersedia']);
        }

        return redirect()->route('pustakawan.peminjaman.index')->with('success', 'Peminjaman berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
