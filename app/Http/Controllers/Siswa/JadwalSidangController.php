<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    /**
     * Menampilkan detail jadwal sidang milik siswa yang sedang login.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat.');
        }

        // Cari jadwal sidang yang sesuai dengan siswa_id saat ini
        $jadwal_sidang = JadwalSidang::where('siswa_id', $siswa->id)
            ->with(['pembimbing.user', 'penguji.user'])
            ->first();

        return view('dashboard.siswa.jadwalsidang', compact('jadwal_sidang'));
    }
}
