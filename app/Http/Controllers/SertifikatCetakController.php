<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikatCetakController extends Controller
{
    public function cetak(Sertifikat $sertifikat)
    {
        $user = Auth::user();
        
        if ($user->hasRole('siswa')) {
            $siswa = $user->siswa;
            if (!$siswa || $sertifikat->siswa_id != $siswa->id) {
                abort(403, 'Akses ditolak.');
            }
        }
        
        $sertifikat->load(['siswa.user', 'siswa.pengajuanPkls' => function ($query) {
            $query->where('status', 'disetujui')->with('tempatPkl');
        }, 'siswa.nilaiPkls']);
        
        $siswa = $sertifikat->siswa;
        
        $pengajuan = $siswa->pengajuanPkls->first();
        if (!$pengajuan) {
            abort(404, 'Data pengajuan PKL tidak ditemukan atau belum disetujui.');
        }
        
        $tempatPkl = $pengajuan->tempatPkl;
        
        $nilai = $siswa->nilaiPkls;
        $predikat = 'BAIK'; // Default fallback
        
        if ($nilai && $nilai->nilai_akhir) {
            $score = $nilai->nilai_akhir;
            if ($score >= 90) {
                $predikat = 'SANGAT BAIK';
            } elseif ($score >= 80) {
                $predikat = 'BAIK';
            } elseif ($score >= 70) {
                $predikat = 'CUKUP';
            } else {
                $predikat = 'KURANG';
            }
        }
        
        return view('dashboard.sertifikat_cetak', compact('sertifikat', 'siswa', 'tempatPkl', 'predikat'));
    }
}
