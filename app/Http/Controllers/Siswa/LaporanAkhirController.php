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
    /**
     * Menampilkan halaman upload laporan akhir.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        
        // Cek berapa banyak jurnal harian yang sudah diisi (Distinct digunakan agar 1 hari walau ada >1 kegiatan tetap dihitung 1)
        $dailyJournalCount = LaporanHarian::where('siswa_id', $siswa->id)->distinct('tanggal')->count('tanggal');
        
        // Ambil data laporan akhir siswa jika sudah pernah upload
        $laporan_akhir = LaporanAkhir::where('siswa_id', $siswa->id)->latest()->first();
        
        $minDailyJournals = 90; // Aturan bisnis: Laporan akhir baru bisa diunggah setelah PKL 90 hari / 3 bulan

        return view('dashboard.siswa.laporan_akhir', compact('laporan_akhir', 'pengajuan_disetujui', 'dailyJournalCount', 'minDailyJournals'));
    }

    /**
     * Memproses upload file laporan akhir (PDF) siswa.
     */
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        // --- Pengecekan Syarat PKL (Pengajuan disetujui & Jurnal Minimal) ---
        $pengajuan_disetujui = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();
        if (!$pengajuan_disetujui) {
            return redirect()->back()->with('error', 'Anda belum memiliki tempat PKL yang disetujui.');
        }

        $minDailyJournals = 90;
        $dailyJournalCount = LaporanHarian::where('siswa_id', $siswa->id)->distinct('tanggal')->count('tanggal');
        if ($dailyJournalCount < $minDailyJournals) {
            return redirect()->back()->with('error', "Anda belum bisa mengunggah laporan akhir. Anda harus mengisi minimal {$minDailyJournals} jurnal harian (saat ini baru terisi {$dailyJournalCount} jurnal).");
        }

        // Validasi ekstensi file harus PDF dengan ukuran max 10MB
        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf|max:10240',
        ]);

        $existingLaporan = LaporanAkhir::where('siswa_id', $siswa->id)->first();
        // Kalau laporannya sudah pernah di-ACC, ga bisa ditimpa ulang (upload baru dilarang).
        if ($existingLaporan && $existingLaporan->status_verifikasi === 'disetujui') {
            return redirect()->back()->with('error', 'Laporan Akhir Anda sudah disetujui. Anda tidak dapat mengubah file laporan lagi.');
        }

        // Simpan file pdf secara lokal di dalam folder `storage/app/public/laporan_akhir`
        $filePath = $request->file('file_laporan')->store('laporan_akhir', 'public');

        // Gunakan updateOrCreate supaya jika siswa mengunggah ulang (revisi), baris database tidak di-duplicate tapi diupdate
        LaporanAkhir::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'file_laporan' => $filePath,
                'status_verifikasi' => 'disetujui', // Status default
                'catatan_pembimbing' => null,
            ]
        );

        // --- NOTIFIKASI KE ADMIN ---
        // Mencari semua pengguna dengan role admin
        $admins = \App\Models\User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\PklNotification(
                'Laporan Akhir Diunggah',
                "{$siswa->user->name} telah mengunggah Laporan Akhir.",
                route('admin.siswa.index'), // Assuming admin manages it here or just generic link
                'file-text'
            ));
        }

        // --- NOTIFIKASI KE PEMBIMBING ---
        if ($siswa->pembimbing && $siswa->pembimbing->user) {
            $siswa->pembimbing->user->notify(new \App\Notifications\PklNotification(
                'Laporan Akhir Diunggah',
                "{$siswa->user->name} telah mengunggah Laporan Akhir dan siap untuk dijadwalkan sidang.",
                route('pembimbing.jadwal-sidang.index'),
                'file-text'
            ));
        }

        return redirect()->route('siswa.laporan-akhir.index')->with('success', 'Berkas Laporan Akhir berhasil diunggah. Anda kini siap untuk dijadwalkan ujian sidang oleh pembimbing.');
    }
}
