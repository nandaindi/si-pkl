<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat.');
        }

        $jadwal_sidang = JadwalSidang::where('siswa_id', $siswa->id)
            ->with(['pembimbing.user', 'penguji.user'])
            ->first();

        return view('dashboard.siswa.jadwalsidang', compact('jadwal_sidang'));
    }
}
