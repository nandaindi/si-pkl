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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gurus = Guru::whereHas('user', function ($query) {
            $query->role('pembimbing');
        })
        ->when($search, function ($query, $search) {
            $query->where('nip', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })->latest()
        ->with('user')->paginate(10);
        return view('dashboard.admin.gurupembimbing', compact('gurus'));
    }

    public function create()
    {
        return view('dashboard.admin.gurupembimbing.create');
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
            $user->assignRole('pembimbing');

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil ditambahkan.');
    }

    public function edit(Guru $guru_pembimbing)
    {
        return view('dashboard.admin.gurupembimbing.edit', ['guru' => $guru_pembimbing]);
    }

    public function update(Request $request, Guru $guru_pembimbing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$guru_pembimbing->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'required|string|unique:gurus,nip,'.$guru_pembimbing->id,
        ]);

        DB::transaction(function () use ($request, $guru_pembimbing) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $guru_pembimbing->user->update($userData);

            $guru_pembimbing->update([
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil diperbarui.');
    }

    public function destroy(Guru $guru_pembimbing)
    {
        $guru_pembimbing->user->delete();
        return redirect()->route('admin.guru-pembimbing.index')->with('success', 'Data Guru Pembimbing berhasil dihapus.');
    }
}
