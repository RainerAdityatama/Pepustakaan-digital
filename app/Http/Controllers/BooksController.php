<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stok;
use App\Models\Books;
use App\Models\Category;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Books::all();

        return view('pustakawan.books.index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('pustakawan.books.add', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'title' => [
                    Rule::unique('books')->where(function ($query) use ($request) {
                        return $query->whereRaw('LOWER(title) = ?', [strtolower($request->title)]);
                    })
                ],
                'author' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'stock' => 'required|integer|min:1',
            ],
            [
                'category_id.required' => 'Category harus diisi',
                'title.required' => 'Judul harus diisi',
                'title.unique'    => 'Nama Buku sudah terdaftar, silahkan isi nama Buku lain.',
                'author.required' => 'Author harus diisi',
                'publisher.required' => 'Publisher harus diisi',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'year.required' => 'Tahun terbit harus diisi.',
                'year.digits' => 'Tahun terbit harus terdiri dari 4 angka.',
                'year.integer' => 'Tahun terbit harus berupa angka.',
                'year.min' => 'Tahun terbit tidak boleh kurang dari 1900.',
                'year.max' => 'Tahun terbit tidak boleh melebihi tahun depan.',
                'file_path.required' => 'Gambar sampul harus diunggah.',
                'file_path.image' => 'File yang diunggah harus berupa gambar.',
                'file_path.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
                'file_path.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'stock.required' => 'Jumlah stok harus diisi.',
                'stock.integer' => 'Jumlah stok harus berupa angka.',
                'stock.min' => 'Jumlah stok minimal adalah 1.',
            ]
        );

        try {
            DB::transaction(function () use ($request, $validasi) {

                $validasi_buku = collect($validasi)->except(['stock', 'file_path'])->all();

                if ($request->hasFile('file_path')) {

                    $path = $request->file('file_path')->store('images', 'public');

                    $validasi_buku['file_path'] = $path;
                }

                $book = Books::create($validasi_buku);

                $stocks = [];
                for ($i = 0; $i < $validasi['stock']; $i++) {
                    $stocks[] = ['book_id' => $book->id, 'created_at' => now(), 'updated_at' => now()];
                }

                DB::table('stoks')->insert($stocks);
            });
        } catch (Exception $e) {

            return redirect()->back()->with('error', 'Gagal menambah buku. Silakan coba lagi.');
            Log::error($e->getMessage());
        }

        return redirect()->route('pustakawan.books.index')->with('success', 'Buku berhasil ditambah');
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
        $book = Books::findOrFail($id);

        $categories = Category::all();

        return view('pustakawan.books.edit', [
            'book' => $book,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Books $book)
    {
        $validasi_buku = $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'title'       => [
                    'required',
                    'string',
                    'max:255',
                    // ignore() agar mengabaikan judul sekarang unik nya
                    Rule::unique('books')->ignore($book->id),
                ],
                'author' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'category_id.required' => 'Category harus diisi',
                'title.required' => 'Judul harus diisi',
                'title.unique'    => 'Nama Buku sudah terdaftar, silahkan isi nama Buku lain.',
                'author.required' => 'Author harus diisi',
                'publisher.required' => 'Publisher harus diisi',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'year.required' => 'Tahun terbit harus diisi.',
                'year.digits' => 'Tahun terbit harus terdiri dari 4 angka.',
                'year.integer' => 'Tahun terbit harus berupa angka.',
                'year.min' => 'Tahun terbit tidak boleh kurang dari 1900.',
                'year.max' => 'Tahun terbit tidak boleh melebihi tahun depan.',
                'file_path.image' => 'File yang diunggah harus berupa gambar.',
                'file_path.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
                'file_path.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            ]
        );

        try {
            DB::transaction(function () use ($request, $validasi_buku, $book) {

                if ($request->hasFile('file_path')) {

                    if ($book->file_path) {
                        Storage::delete('public/' . $book->file_path);
                    }

                    $path = $request->file('file_path')->store('images', 'public');

                    $validasi_buku['file_path'] = $path;
                }

                $book->update($validasi_buku);
            });
        } catch (Exception $e) {

            Log::error('Gagal update buku: ' . $e->getMessage());
            // Jika terjadi error di dalam transaction, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengubah buku. Silakan coba lagi.');
        }

        return redirect()->route('pustakawan.books.index')->with('success', 'Buku berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Books::FindOrfail($id);

        $peminjaman =  Peminjaman::where('book_id', $id)->exists();

        if ($peminjaman) {
            return redirect()->back()->with('error', 'Buku tidak dapat dihapus karena sedang terlibat pada peminjaman.');
        }

        $book->delete();

        return redirect()->route('pustakawan.books.index')->with('success', 'Buku berhasil dihapus');
    }

    public function manageStock(Books $book) 
    {
        // ambil data stok berdasrkan id book di halaman edit 
        $book->load('stock');

        return view('pustakawan.books.stocks', ['book' => $book]);
    }

    public function addStock(Request $request, Books $book)
    {
         $validated =  $request->validate([
            'stock' => 'required|integer|min:1|max:1000',
        ]);

         $quantity = $validated['stock'];
         $insert_data = [];
         $now = now();

         for ($i = 0; $i < $quantity; $i++) {
                $insert_data[] = [
                    'book_id' => $book->id,
                    'status' => 'tersedia',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
         }

        Stok::insert($insert_data);

        return back()->with('success', "{$quantity} stok berhasil ditambahkan.");
    }

    public function removeStock(Stok $stock)
    {
        $stock->delete();

        return back()->with('success', 'Satu unit stok berhasil dihapus.');
    }
}
