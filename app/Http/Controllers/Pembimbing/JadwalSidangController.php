<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $search = $request->input('search');
        $jadwals = $guru 
            ? JadwalSidang::where('pembimbing_id', $guru->id)
                ->whereDoesntHave('siswa.sertifikat')
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'penguji.user'])->orderBy('waktu', 'asc')->paginate(10) 
            : collect();

        return view('dashboard.pembimbing.jadwalsidang', compact('jadwals'));
    }

    public function create()
    {
        $guru = Auth::user()->guru;
        
        $siswas = \App\Models\Siswa::where('pembimbing_id', $guru->id)
            ->whereHas('laporanAkhirs', function($q) {
                $q->where('status_verifikasi', 'disetujui');
            })
            ->whereDoesntHave('jadwalSidangs')
            ->get();
            
        $pengujis = \App\Models\Guru::whereHas('user', function($q) {
            $q->whereHas('roles', function($r) {
                $r->where('name', 'penguji');
            });
        })->get();
        
        return view('dashboard.pembimbing.jadwalsidang_create', compact('siswas', 'pengujis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'penguji_id' => 'required|exists:gurus,id',
            'waktu' => 'required|date',
            'ruangan' => 'required|string|max:255',
        ]);

        JadwalSidang::create([
            'siswa_id' => $request->siswa_id,
            'pembimbing_id' => Auth::user()->guru->id,
            'penguji_id' => $request->penguji_id,
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
        ]);

        return redirect()->route('pembimbing.jadwal-sidang.index')->with('success', 'Jadwal sidang berhasil dibuat.');
    }

    public function edit(JadwalSidang $jadwal_sidang)
    {
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);
        
        $pengujis = \App\Models\Guru::whereHas('user', function($q) {
            $q->whereHas('roles', function($r) {
                $r->where('name', 'penguji');
            });
        })->get();

        return view('dashboard.pembimbing.jadwalsidang_edit', compact('jadwal_sidang', 'pengujis'));
    }

    public function update(Request $request, JadwalSidang $jadwal_sidang)
    {
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);

        $request->validate([
            'penguji_id' => 'required|exists:gurus,id',
            'waktu' => 'required|date',
            'ruangan' => 'required|string|max:255',
        ]);

        $jadwal_sidang->update([
            'penguji_id' => $request->penguji_id,
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
        ]);

        return redirect()->route('pembimbing.jadwal-sidang.index')->with('success', 'Jadwal sidang berhasil diperbarui.');
    }

    public function destroy(JadwalSidang $jadwal_sidang)
    {
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);
        
        $jadwal_sidang->delete();

        return redirect()->route('pembimbing.jadwal-sidang.index')->with('success', 'Jadwal sidang berhasil dihapus.');
    }
}
