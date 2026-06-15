<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\Siswa;

class LaporanHarianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $laporans = LaporanHarian::with('siswa.user')
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('dashboard.pembimbing.laporan_harian_index', compact('laporans'));
    }

    public function show(Siswa $siswa)
    {
        $laporans = LaporanHarian::where('siswa_id', $siswa->id)->orderBy('tanggal', 'desc')->get();
        return view('dashboard.pembimbing.laporan_harian_show', compact('siswa', 'laporans'));
    }

    public function verifikasi(Request $request, LaporanHarian $laporan)
    {
        $request->validate([
            'status' => 'required|in:disetujui,revisi',
        ]);

        $laporan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status laporan harian berhasil diperbarui.');
    }
}
