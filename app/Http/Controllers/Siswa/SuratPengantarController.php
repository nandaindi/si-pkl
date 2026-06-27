<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPkl;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SuratPengantarController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan = PengajuanPkl::where('siswa_id', $siswa->id)
            ->where('status', 'disetujui')
            ->with('tempatPkl')
            ->latest()
            ->first();

        return view('dashboard.siswa.surat_pengantar', compact('pengajuan'));
    }

    public function cetak(PengajuanPkl $pengajuan)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa || $pengajuan->siswa_id != $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($pengajuan->status !== 'disetujui') {
            return redirect()->route('siswa.surat-pengantar.index')->with('error', 'Surat pengantar belum tersedia karena pengajuan belum disetujui.');
        }

        $tempat_pkl_id = $pengajuan->tempat_pkl_id;

        $siswa_list = collect([$siswa]);

        return view('dashboard.pembimbing.surat_pengantar_cetak', compact('pengajuan', 'siswa_list'));
    }
}
