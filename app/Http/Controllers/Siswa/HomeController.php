<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $siswa = $request->user()->siswa;
        
        $pengajuan_pkl = $siswa ? $siswa->pengajuanPkls()->with('tempatPkl')->latest()->first() : null;
        $laporan_harian_count = $siswa ? $siswa->laporanHarians()->distinct('tanggal')->count('tanggal') : 0;
        $jadwal_sidang = $siswa ? $siswa->jadwalSidangs()->with(['pembimbing.user', 'penguji.user'])->first() : null;
        $sertifikat = $siswa ? $siswa->sertifikat()->first() : null;
        
        $belum_isi_laporan_hari_ini = false;
        if ($siswa && $pengajuan_pkl && $pengajuan_pkl->status === 'disetujui') {
            if (\Carbon\Carbon::today()->isWeekday()) {
                $laporan_hari_ini = $siswa->laporanHarians()->whereDate('tanggal', \Carbon\Carbon::today())->exists();
                if (!$laporan_hari_ini) {
                    $belum_isi_laporan_hari_ini = true;
                }
            }
        }
        
        return view('dashboard.siswa.index', compact(
            'siswa',
            'pengajuan_pkl',
            'laporan_harian_count',
            'jadwal_sidang',
            'sertifikat',
            'belum_isi_laporan_hari_ini'
        ));
    }
}
