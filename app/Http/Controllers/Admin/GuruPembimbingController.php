<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruPembimbingController extends Controller
{
    /**
     * Menampilkan daftar Guru Pembimbing beserta fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Query model Guru yang usernya memiliki role 'pembimbing'
        $gurus = Guru::whereHas('user', function ($query) {
            $query->role('pembimbing');
        })
        // Filter pencarian berdasarkan NIP atau nama (jika $search ada isinya)
        ->when($search, function ($query, $search) {
            $query->where('nip', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })->latest()
        ->with('user')->paginate(10); // Eager load relasi 'user' dan paginasi 10 data
        
        return view('dashboard.admin.gurupembimbing', compact('gurus'));
    }

    /**
     * Menampilkan form tambah Guru Pembimbing.
     */
    public function create()
    {
        return view('dashboard.admin.gurupembimbing.create');
    }

    /**
     * Menyimpan data Guru Pembimbing baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // email harus unik di tabel users
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:gurus', // NIP harus unik di tabel gurus
        ]);

        // 2. DB::transaction memastikan jika salah satu query gagal, maka query sebelumnya dibatalkan (rollback).
        DB::transaction(function () use ($request) {
            // Buat akun User terlebih dahulu
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Password selalu di-hash
            ]);
            // Berikan hak akses 'pembimbing'
            $user->assignRole('pembimbing');

            // Buat data Profil Guru yang terhubung dengan User ID yang baru saja dibuat
            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data Guru Pembimbing.
     */
    public function edit(Guru $guru_pembimbing)
    {
        // Parameter $guru_pembimbing otomatis mengambil data dari database berkat fitur Route Model Binding.
        return view('dashboard.admin.gurupembimbing.edit', ['guru' => $guru_pembimbing]);
    }

    /**
     * Memperbarui data Guru Pembimbing.
     */
    public function update(Request $request, Guru $guru_pembimbing)
    {
        // Validasi: pastikan email unik KECUALI untuk email milik user ini sendiri (biar bisa disimpan tanpa error).
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$guru_pembimbing->user_id,
            'password' => 'nullable|string|min:8|confirmed', // nullable berarti password opsional diubah
            'nip' => 'required|string|unique:gurus,nip,'.$guru_pembimbing->id,
        ]);

        DB::transaction(function () use ($request, $guru_pembimbing) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            // Jika user mengisi kolom password di form edit, maka update passwordnya
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $guru_pembimbing->user->update($userData);

            // Update NIP guru
            $guru_pembimbing->update([
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil diperbarui.');
    }

    /**
     * Menghapus data Guru Pembimbing.
     */
    public function destroy(Guru $guru_pembimbing)
    {
        // Jika kita menghapus User-nya, data Guru juga akan otomatis terhapus berkat aturan foreign key constraint (onDelete cascade) di database,
        // atau kita menghapus dari model User langsung.
        $guru_pembimbing->user->delete();
        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil dihapus.');
    }
}
