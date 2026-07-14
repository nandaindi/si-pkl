<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;

class JadwalSidangController extends Controller
{
    /**
     * Menampilkan daftar jadwal sidang di mana guru yang login bertugas sebagai penguji.
     */
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $search = $request->input('search');
        
        $jadwals = $guru 
            ? JadwalSidang::where('penguji_id', $guru->id)
                ->whereDoesntHave('siswa.sertifikat') // Abaikan yang sudah lulus
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'siswa.nilaiPkls', 'pembimbing.user'])->orderBy('waktu', 'asc')->paginate(10) 
            : collect();

        return view('dashboard.penguji.jadwalsidang', compact('jadwals'));
    }
}
