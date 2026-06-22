<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\LaporanHarian;
use App\Models\LaporanAkhir;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $laporan_akhirs = LaporanAkhir::whereHas('siswa', function ($q) {
                $q->where('pembimbing_id', auth()->user()->guru->id);
            })
            ->with('siswa.user')
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()->paginate(10);

        return view('dashboard.pembimbing.laporan', compact('laporan_akhirs'));
    }

}
