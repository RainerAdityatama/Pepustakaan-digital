<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dendas = Denda::all();

        return view('pustakawan.denda.index', [
            'dendas' => $dendas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjamans = Peminjaman::whereNotNull('tanggal_pengembalian')
            ->where('denda', '>', 0) // Lebih baik menggunakan > 0 daripada != 0
            ->whereDoesntHave('denda') // Cek jika tidak ada relasi denda
            ->get();

        return view('pustakawan.denda.add', [
            'peminjamans' => $peminjamans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_data = $request->validate(
            [
                'peminjaman_id' => 'required|exists:peminjamans,id',
                'jumlah_denda' => 'required|integer|min:2000'
            ],
            [
                'peminjaman_id.required'  => 'Id Peminjaman harus diisi',
                'jumlah_denda.required'    => 'Jumlah Denda harus diisi',
                'jumlah_denda.integer'    => 'Jumlah Denda harus berupa angka',
                'jumlah_denda.min'    => 'Jumlah Denda minimal Rp2000',
            ]
        );

        Denda::create($validate_data);

        return redirect()->route('pustakawan.denda.index')->with('success', 'Denda berhasil ditambah');
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

        $denda = Denda::FindOrfail($id);

        return view('pustakawan.denda.edit', [
            'denda' => $denda,
            'statuses' => Denda::STATUS_OPTIONS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate(
            [
                'jumlah_denda' => 'required|integer|min:2000',
                'status' => ['required', Rule::in(Denda::STATUS_OPTIONS)]
            ],
            [
                'jumlah_denda.required' => 'Jumlah Denda harus diisi',
                'jumlah_denda.integer'  => 'Jumlah Denda harus berupa angka',
                'jumlah_denda.min'      => 'Jumlah Denda minimal Rp2000',
                'status.required'       => 'Status harus diisi',
                'status.in'             => 'Status yang dipilih tidak valid',
            ]
        );

        $denda = Denda::FindOrfail($id);

        $denda->update($validasi);

        return redirect()->route('pustakawan.denda.index')->with('success', 'Denda berhasil ditambah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
