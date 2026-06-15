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
        $laporan_akhirs = LaporanAkhir::with('siswa.user')
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()->get();

        return view('dashboard.pembimbing.laporan', compact('laporan_akhirs'));
    }

    public function verifikasi(Request $request, LaporanAkhir $laporan)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,revisi',
            'catatan_pembimbing' => 'required|string',
        ]);

        $laporan->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_pembimbing' => $request->catatan_pembimbing,
        ]);

        return redirect()->route('pembimbing.laporan.index')->with('success', 'Status laporan akhir siswa berhasil diperbarui.');
    }
}
