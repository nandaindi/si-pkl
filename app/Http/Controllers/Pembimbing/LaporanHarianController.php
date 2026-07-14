<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\Siswa;

class LaporanHarianController extends Controller
{
    /**
     * Menampilkan daftar siswa bimbingan beserta rekapitulasi jumlah laporan hariannya.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Cari siswa bimbingan guru ini yang sudah memiliki setidaknya 1 laporan harian.
        $siswas = Siswa::where('pembimbing_id', auth()->user()->guru->id)
            ->whereHas('laporanHarians')
            ->withCount('laporanHarians') // Menambahkan properti otomatis "laporan_harians_count"
            ->with([
                'user',
                'laporanHarians' => function ($query) {
                    $query->latest('tanggal'); // Sortir relasi dari yang terbaru
                },
            ])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('dashboard.pembimbing.laporan_harian_index', compact('siswas'));
    }

    /**
     * Menampilkan detail semua laporan harian untuk satu siswa.
     */
    public function show(Siswa $siswa)
    {
        $laporans = LaporanHarian::where('siswa_id', $siswa->id)->orderBy('tanggal', 'desc')->get();
        return view('dashboard.pembimbing.laporan_harian_show', compact('siswa', 'laporans'));
    }

    /**
     * Memverifikasi (menyetujui/minta revisi) laporan harian yang di-submit siswa.
     */
    public function verifikasi(Request $request, LaporanHarian $laporan)
    {
        // Hanya ada dua kemungkinan status verifikasi dari form
        $request->validate([
            'status' => 'required|in:disetujui,revisi',
        ]);

        $laporan->update([
            'status' => $request->status,
        ]);

        // Jika berhasil di-update, kirimkan In-App Notification (menggunakan package bawaan Laravel Database Notification) ke siswa
        if ($laporan->siswa && $laporan->siswa->user) {
            $msg =
                $request->status === 'disetujui'
                    ? 'Jurnal harian Anda tanggal ' .
                        \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') .
                        ' telah DISETUJUI.'
                    : 'Jurnal harian Anda tanggal ' .
                        \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') .
                        ' perlu DIREVISI.';
            $icon = $request->status === 'disetujui' ? 'check-circle' : 'alert-circle';

            $laporan->siswa->user->notify(
                new \App\Notifications\PklNotification(
                    'Status Jurnal Harian',
                    $msg,
                    route('siswa.jurnal-harian.index', ['tab' => 'riwayat']),
                    $icon,
                ),
            );
        }

        return redirect()->back()->with('success', 'Status laporan harian berhasil diperbarui.');
    }
}
