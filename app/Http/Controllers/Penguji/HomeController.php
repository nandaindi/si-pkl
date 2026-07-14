<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Guru Penguji.
     */
    public function index(Request $request)
    {
        $guru = $request->user()->guru;
        
        // Menghitung berapa banyak jadwal sidang di mana guru ini bertindak sebagai penguji.
        $ujian_sidang_count = $guru ? JadwalSidang::where('penguji_id', $guru->id)->count() : 0;
        
        // Mengambil daftar jadwal sidang tersebut lengkap dengan data siswa
        $ujians = $guru ? JadwalSidang::where('penguji_id', $guru->id)->with('siswa.user')->get() : collect();
        
        return view('dashboard.penguji.index', compact(
            'guru',
            'ujian_sidang_count',
            'ujians'
        ));
    }
}
