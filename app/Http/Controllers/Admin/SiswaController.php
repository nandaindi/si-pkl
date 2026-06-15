<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $siswas = Siswa::with('user')
            ->when($search, function ($query, $search) {
                $query->where('nisn', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->get();
        return view('dashboard.admin.siswa', compact('siswas'));
    }

    public function create()
    {
        return view('dashboard.admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nisn' => 'required|string|unique:siswas',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        return view('dashboard.admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$siswa->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nisn' => 'required|string|unique:siswas,nisn,'.$siswa->id,
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $siswa->user->update($userData);

            $siswa->update([
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }
}
