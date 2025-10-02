<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Userdenda extends Controller
{
    public function index()
    {
        $dendas = Denda::whereHas('peminjaman', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();;

        return view('user.denda_user.index', [
            'dendas' => $dendas
        ]);
    }
}
