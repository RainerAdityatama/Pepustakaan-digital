<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('pustakawan.category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pustakawan.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate(
            [
                'nama' => [
                    'required',
                    'min:3',
                    Rule::unique('categories')->where(function ($query) use ($request) {
                        return $query->whereRaw('LOWER(nama) = ?', [strtolower($request->nama)]);
                    }),
                ]
            ],
            [
                'nama.required'  => 'Nama Category harus diisi.',
                'nama.unique'    => 'Nama Category sudah terdaftar, silahkan isi nama category lain.',
            ]
        );

        try {
            DB::beginTransaction();

            Category::create($validasi);

            DB::commit();
        } catch (Exception $e) {

            // Jika terjadi error di dalam transaction, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal menambah Category. Silakan coba lagi.');
            // Opsional: Anda bisa menambahkan log untuk error di sini
            Log::error($e->getMessage());
        }

        return redirect()->route('pustakawan.category.index')->with('success', 'Category berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::FindOrfail($id);

        return view('pustakawan.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate(
            [
                'nama' => [
                    'required',
                    'min:3',
                    Rule::unique('categories')->where(function ($query) use ($request) {
                        return $query->whereRaw('LOWER(nama) = ?', [strtolower($request->nama)]);
                    }),
                ]
            ],
            [
                'nama.required'  => 'Nama Category harus diisi.',
                'nama.unique'    => 'Nama Category sudah terdaftar, silahkan isi nama category lain.',
            ]
        );

        try {
            DB::beginTransaction();

            $category = Category::FindOrfail($id);

            $category->update($validasi);

            DB::commit();
        } catch (Exception $e) {

            // Jika terjadi error di dalam transaction, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengubah Category. Silakan coba lagi.');
            // Opsional: Anda bisa menambahkan log untuk error di sini
            Log::error($e->getMessage());
        }

        return redirect()->route('pustakawan.category.index')->with('success', 'Category berhasil ditambah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $peminjaman =  Peminjaman::whereHas('book', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->exists();

        if ($peminjaman) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena sedang terlibat pada peminjaman.');
        }

        try {
            $category = Category::FindorFail($id);

            DB::beginTransaction();

            $category->delete();

            DB::commit();
        } catch (Exception $e) {

            // Jika terjadi error di dalam transaction, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengubah Category. Silakan coba lagi.');
            // Opsional: Anda bisa menambahkan log untuk error di sini
            Log::error($e->getMessage());
        }

        return redirect()->route('pustakawan.category.index')->with('success', 'Category berhasil dihapus');
    }
}
