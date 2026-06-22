<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruPengujiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gurus = Guru::whereHas('user', function ($query) {
            $query->role('penguji');
        })
        ->when($search, function ($query, $search) {
            $query->where('nip', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })->latest()
        ->with('user')->paginate(10);
        return view('dashboard.admin.gurupenguji', compact('gurus'));
    }

    public function create()
    {
        return view('dashboard.admin.gurupenguji.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:gurus',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('penguji');

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-penguji.index')->with('success', 'Data Guru Penguji berhasil ditambahkan.');
    }

    public function edit(Guru $guru_penguji)
    {
        return view('dashboard.admin.gurupenguji.edit', ['guru' => $guru_penguji]);
    }

    public function update(Request $request, Guru $guru_penguji)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$guru_penguji->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'required|string|unique:gurus,nip,'.$guru_penguji->id,
        ]);

        DB::transaction(function () use ($request, $guru_penguji) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $guru_penguji->user->update($userData);

            $guru_penguji->update([
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-penguji.index')->with('success', 'Data Guru Penguji berhasil diperbarui.');
    }

    public function destroy(Guru $guru_penguji)
    {
        $guru_penguji->user->delete();
        return redirect()->route('admin.guru-penguji.index')->with('success', 'Data Guru Penguji berhasil dihapus.');
    }
}
