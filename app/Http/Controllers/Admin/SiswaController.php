<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Mengambil data siswa (termasuk relasi usernya) dan memfilter jika ada pencarian.
        $siswas = Siswa::with('user')
            ->when($search, function ($query, $search) {
                // Pencarian bisa menggunakan NISN atau Nama (yang tersimpan di tabel user)
                $query->where('nisn', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest() // Mengurutkan dari yang terbaru dibuat
            ->paginate(10); // Menampilkan 10 data per halaman
            
        return view('dashboard.admin.siswa', compact('siswas'));
    }

    /**
     * Menampilkan form tambah Siswa.
     */
    public function create()
    {
        // Mengambil semua guru yang memiliki role 'pembimbing' untuk pilihan dropdown di form.
        $pembimbings = Guru::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('name', 'pembimbing');
            });
        })->with('user')->get();
        
        return view('dashboard.admin.siswa.create', compact('pembimbings'));
    }

    /**
     * Menyimpan data Siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nisn' => 'required|string|unique:siswas',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'pembimbing_id' => 'nullable|exists:gurus,id', // Harus guru yang ada di DB, atau boleh kosong.
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat akun user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('siswa'); // Assign role siswa

            // 2. Buat profil siswanya berdasarkan akun yang baru terbuat
            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'pembimbing_id' => $request->pembimbing_id,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk siswa tertentu.
     */
    public function edit(Siswa $siswa)
    {
        // Tetap mengambil daftar pembimbing untuk opsi edit dropdown.
        $pembimbings = Guru::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($q2) {
                $q2->where('name', 'pembimbing');
            });
        })->with('user')->get();
        
        return view('dashboard.admin.siswa.edit', compact('siswa', 'pembimbings'));
    }

    /**
     * Memperbarui (update) data siswa yang ada di database.
     */
    public function update(Request $request, Siswa $siswa)
    {
        // Validasi, pastikan NISN dan Email unik tetapi abaikan id data saat ini.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$siswa->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nisn' => 'required|string|unique:siswas,nisn,'.$siswa->id,
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'pembimbing_id' => 'nullable|exists:gurus,id',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            // Ubah password hanya jika admin menginput password baru
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $siswa->user->update($userData);

            $siswa->update([
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'pembimbing_id' => $request->pembimbing_id,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    /**
     * Menghapus siswa secara permanen.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }
}
