<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\PengajuanPkl;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $guru = $request->user()->guru;
        
        $bimbingan_sidang_count = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->count() : 0;
        $bimbingans = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->with('siswa.user')->get() : collect();
        $pending_pengajuan_count = $guru ? PengajuanPkl::where('status', 'pending')
            ->whereHas('siswa', function ($q) use ($guru) {
                $q->where('pembimbing_id', $guru->id);
            })->count() : 0;
        
        return view('dashboard.pembimbing.index', compact(
            'guru',
            'bimbingan_sidang_count',
            'bimbingans',
            'pending_pengajuan_count'
        ));
    }
}
