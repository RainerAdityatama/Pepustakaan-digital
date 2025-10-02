<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Userpeminjaman extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())->get();

        return view('user.peminjaman_user.index', [
            'peminjamans' => $peminjamans
        ]);
    }
}
