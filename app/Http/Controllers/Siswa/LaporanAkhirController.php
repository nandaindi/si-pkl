<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use App\Models\LaporanAkhir;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\Auth;

class LaporanAkhirController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        $dailyJournalCount = LaporanHarian::where('siswa_id', $siswa->id)->distinct('tanggal')->count('tanggal');
        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->latest()->first();
        
        $minDailyJournals = 90; // 3 months

        return view('dashboard.siswa.laporan_akhir', compact('laporan_akhir', 'pengajuan_disetujui', 'dailyJournalCount', 'minDailyJournals'));
    }

    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        if (!$pengajuan_disetujui) {
            return redirect()->back()->with('error', 'Anda belum memiliki tempat PKL yang disetujui.');
        }

        $minDailyJournals = 90;
        $dailyJournalCount = LaporanHarian::where('siswa_id', $siswa->id)->distinct('tanggal')->count('tanggal');
        if ($dailyJournalCount < $minDailyJournals) {
            return redirect()->back()->with('error', "Anda belum bisa mengunggah laporan akhir. Anda harus mengisi minimal {$minDailyJournals} jurnal harian (saat ini baru terisi {$dailyJournalCount} jurnal).");
        }

        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf|max:10240',
        ]);

        $existingLaporan = LaporanAkhir::where('siswa_id', $siswa->id)->first();
        if ($existingLaporan && $existingLaporan->status_verifikasi === 'disetujui') {
            return redirect()->back()->with('error', 'Laporan Akhir Anda sudah disetujui. Anda tidak dapat mengubah file laporan lagi.');
        }

        $filePath = $request->file('file_laporan')->store('laporan_akhir', 'public');

        LaporanAkhir::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'file_laporan' => $filePath,
                'status_verifikasi' => 'pending',
                'catatan_pembimbing' => null,
            ]
        );

        // Notify Admins
        $admins = \App\Models\User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\PklNotification(
                'Laporan Akhir Diunggah',
                "{$siswa->user->name} telah mengunggah Laporan Akhir.",
                route('admin.siswa.index'), // Assuming admin manages it here or just generic link
                'file-text'
            ));
        }

        // Notify Pembimbing
        if ($siswa->pembimbing && $siswa->pembimbing->user) {
            $siswa->pembimbing->user->notify(new \App\Notifications\PklNotification(
                'Laporan Akhir Diunggah',
                "{$siswa->user->name} telah mengunggah Laporan Akhir menunggu verifikasi.",
                route('pembimbing.laporan.index'),
                'file-text'
            ));
        }

        return redirect()->route('siswa.laporan-akhir.index')->with('success', 'Berkas Laporan Akhir berhasil diunggah. Menunggu persetujuan pembimbing.');
    }
}
