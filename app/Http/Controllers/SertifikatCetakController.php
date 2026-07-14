<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikatCetakController extends Controller
{
    /**
     * Memproses dan menampilkan halaman khusus untuk mencetak (print/PDF) Sertifikat PKL siswa.
     */
    public function cetak(Sertifikat $sertifikat)
    {
        // 1. Dapatkan user yang sedang mengakses fitur cetak.
        $user = Auth::user();
        
        // 2. Keamanan: Jika yang mengakses adalah siswa, 
        // pastikan dia HANYA bisa mencetak sertifikat yang merupakan miliknya sendiri.
        if ($user->hasRole('siswa')) {
            $siswa = $user->siswa;
            if (!$siswa || $sertifikat->siswa_id != $siswa->id) {
                abort(403, 'Akses ditolak.'); // Tampilkan error 403 Forbidden (Terlarang)
            }
        }
        
        // 3. Eager Loading Relasi (Memuat relasi database secara bersamaan agar cepat):
        // Memanggil data siswa, akun user siswa, pengajuan PKL yang 'disetujui' saja, dan nilai PKL.
        $sertifikat->load(['siswa.user', 'siswa.pengajuanPkls' => function ($query) {
            $query->where('status', 'disetujui')->with('tempatPkl');
        }, 'siswa.nilaiPkls']);
        
        $siswa = $sertifikat->siswa;
        
        // 4. Ambil data pengajuan pertama dari hasil filter di atas.
        $pengajuan = $siswa->pengajuanPkls->first();
        if (!$pengajuan) {
            abort(404, 'Data pengajuan PKL tidak ditemukan atau belum disetujui.');
        }
        
        $tempatPkl = $pengajuan->tempatPkl;
        
        // 5. Algoritma Penentuan Predikat Kelulusan berdasarkan Nilai Akhir
        $nilai = $siswa->nilaiPkls;
        $predikat = 'BAIK'; // Default fallback (jaga-jaga jika logika di bawah terlewat)
        
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
        
        // 6. Tampilkan View (halaman desain sertifikat) dan kirim semua variabel yang diperlukan ke file blade.
        return view('dashboard.sertifikat_cetak', compact('sertifikat', 'siswa', 'tempatPkl', 'predikat'));
    }
}
