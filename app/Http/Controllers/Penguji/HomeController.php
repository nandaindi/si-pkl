<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $guru = $request->user()->guru;
        
        $ujian_sidang_count = $guru ? JadwalSidang::where('penguji_id', $guru->id)->count() : 0;
        $ujians = $guru ? JadwalSidang::where('penguji_id', $guru->id)->with('siswa.user')->get() : collect();
        
        return view('dashboard.penguji.index', compact(
            'guru',
            'ujian_sidang_count',
            'ujians'
        ));
    }
}
