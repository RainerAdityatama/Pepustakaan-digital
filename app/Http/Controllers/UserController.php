<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil data user yang rolenya pustakawan dan user
        $users = User::with('roles')->role(['pustakawan', 'user'])->latest()->get();

        // direct ke halaman index
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(User $user)
    {
        // ambil data user beserta dengan rolenya
        $user->load('roles');

        // ambil role selain admin
        $roles = Role::where('name', '!=', 'admin')->get();

        // direct ke halaman edit
        return view('admin.users.edit', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        // 1. Validasi data di luar transaction
        $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        // pake db transaction agar jika terjadi kesalahan maka batalkan semua perubahannya
        try {
            DB::transaction(function () use ($request, $user) {

                // menyingkronkan rolenya agar role awal diganti dengan role yang baru diinput
                $user->syncRoles([$request->role]);

                DB::commit();
            });
        } catch (Exception $e) {

            // Jika terjadi error di dalam transaction, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal mengubah role. Silakan coba lagi.');
            // Opsional: Anda bisa menambahkan log untuk error di sini
            Log::error($e->getMessage());
        }

        // 4. Redirect jika semua berhasil
        return redirect()->route('admin.users.index')->with('success', 'Role berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $peminjaman = Peminjaman::where('user_id', $id)->exists();

        if ($peminjaman) {
            return redirect()->back()->with('error', 'User tidak dapat dihapus karena sedang terlibat pada peminjaman.');
        }

        try {
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            // Opsional: Anda bisa menambahkan log untuk error di sini
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus User. Silakan coba lagi.');
        }
    }
}
