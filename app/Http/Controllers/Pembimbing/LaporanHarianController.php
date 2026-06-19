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
        $siswas = Siswa::where('pembimbing_id', auth()->user()->guru->id)
            ->whereHas('laporanHarians')
            ->withCount('laporanHarians')
            ->with(['user', 'laporanHarians' => function ($query) {
                $query->latest('tanggal');
            }])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->get()
            ->sortByDesc(function ($siswa) {
                return $siswa->laporanHarians->first()->tanggal ?? '';
            });

        return view('dashboard.pembimbing.laporan_harian_index', compact('siswas'));
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

        if ($laporan->siswa && $laporan->siswa->user) {
            $msg = $request->status === 'disetujui' 
                   ? "Jurnal harian Anda tanggal " . \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') . " telah DISETUJUI." 
                   : "Jurnal harian Anda tanggal " . \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') . " perlu DIREVISI.";
            $icon = $request->status === 'disetujui' ? 'check-circle' : 'alert-circle';
            
            $laporan->siswa->user->notify(new \App\Notifications\PklNotification(
                'Status Jurnal Harian',
                $msg,
                route('siswa.jurnal-harian.index', ['tab' => 'riwayat']),
                $icon
            ));
        }

        return redirect()->back()->with('success', 'Status laporan harian berhasil diperbarui.');
    }
}
