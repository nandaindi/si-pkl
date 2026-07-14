<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\PengajuanPkl;

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Guru Pembimbing.
     */
    public function index(Request $request)
    {
        // Mendapatkan data guru yang sedang login
        $guru = $request->user()->guru;
        
        // Menghitung jumlah bimbingan sidang berdasarkan ID guru pembimbing saat ini
        $bimbingan_sidang_count = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->count() : 0;
        
        // Mengambil daftar jadwal sidang berserta data user siswa
        $bimbingans = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->with('siswa.user')->get() : collect();
        
        // Menghitung jumlah pengajuan PKL siswa (yang dibimbing) yang statusnya masih 'pending'
        $pending_pengajuan_count = $guru ? PengajuanPkl::where('status', 'pending')
            ->whereHas('siswa', function ($q) use ($guru) {
                $q->where('pembimbing_id', $guru->id);
            })->count() : 0;
        
        // Mengirim data metrik ke halaman dashboard
        return view('dashboard.pembimbing.index', compact(
            'guru',
            'bimbingan_sidang_count',
            'bimbingans',
            'pending_pengajuan_count'
        ));
    }
}
