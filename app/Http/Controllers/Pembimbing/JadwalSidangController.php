<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    /**
     * Menampilkan daftar jadwal sidang siswa yang dibimbing oleh guru yang sedang login.
     */
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $search = $request->input('search');
        
        // Query untuk menampilkan jadwal sidang:
        // 1. Hanya milik pembimbing saat ini
        // 2. Siswa belum memiliki sertifikat (artinya belum selesai sepenuhnya)
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

    /**
     * Menampilkan form untuk membuat jadwal sidang baru.
     */
    public function create()
    {
        $guru = Auth::user()->guru;
        
        // Siswa yang bisa disidangkan:
        // - Merupakan bimbingan guru ini
        // - Laporan akhirnya sudah "disetujui"
        // - Belum memiliki jadwal sidang sama sekali
        $siswas = \App\Models\Siswa::where('pembimbing_id', $guru->id)
            ->whereHas('laporanAkhirs', function($q) {
                $q->where('status_verifikasi', 'disetujui');
            })
            ->whereDoesntHave('jadwalSidangs')
            ->get();
            
        // Ambil semua guru yang memiliki role sebagai 'penguji'
        $pengujis = \App\Models\Guru::whereHas('user', function($q) {
            $q->whereHas('roles', function($r) {
                $r->where('name', 'penguji');
            });
        })->get();
        
        return view('dashboard.pembimbing.jadwalsidang_create', compact('siswas', 'pengujis'));
    }

    /**
     * Menyimpan jadwal sidang ke database.
     */
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

    /**
     * Menampilkan form edit jadwal sidang.
     */
    public function edit(JadwalSidang $jadwal_sidang)
    {
        // Keamanan: Cek apakah jadwal ini benar dibuat oleh pembimbing yang login.
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);
        
        $pengujis = \App\Models\Guru::whereHas('user', function($q) {
            $q->whereHas('roles', function($r) {
                $r->where('name', 'penguji');
            });
        })->get();

        return view('dashboard.pembimbing.jadwalsidang_edit', compact('jadwal_sidang', 'pengujis'));
    }

    /**
     * Memperbarui jadwal sidang.
     */
    public function update(Request $request, JadwalSidang $jadwal_sidang)
    {
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);

        $request->validate([
            'penguji_id' => 'required|exists:gurus,id',
            'waktu' => 'required|date',
            'ruangan' => 'required|string|max:255',
        ]);

        // Catatan: Siswa tidak diupdate, hanya waktu, ruangan dan pengujinya saja
        $jadwal_sidang->update([
            'penguji_id' => $request->penguji_id,
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
        ]);

        return redirect()->route('pembimbing.jadwal-sidang.index')->with('success', 'Jadwal sidang berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal sidang.
     */
    public function destroy(JadwalSidang $jadwal_sidang)
    {
        if ($jadwal_sidang->pembimbing_id !== Auth::user()->guru->id) abort(403);
        
        $jadwal_sidang->delete();

        return redirect()->route('pembimbing.jadwal-sidang.index')->with('success', 'Jadwal sidang berhasil dihapus.');
    }
}
