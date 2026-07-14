<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\Sertifikat;
use Carbon\Carbon;

class SertifikatController extends Controller
{
    /**
     * Menampilkan daftar siswa bimbingan yang telah masuk jadwal sidang. 
     * Siswa ini berpotensi untuk diterbitkan sertifikatnya jika memenuhi semua syarat.
     */
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $search = $request->input('search');
        
        $jadwals = $guru 
            ? JadwalSidang::where('pembimbing_id', $guru->id)
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                // Eager Load berbagai relasi sekaligus agar hemat query saat di-loop di file Blade
                ->with(['siswa.user', 'siswa.sertifikat', 'siswa.laporanHarians', 'siswa.nilaiPkls', 'siswa.laporanAkhirs'])
                ->paginate(10) 
            : collect();

        return view('dashboard.pembimbing.sertifikat', compact('jadwals'));
    }

    /**
     * Mengeksekusi proses pembuatan / generate Sertifikat PKL siswa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        $siswaId = $request->siswa_id;

        // --- 1. Generate Nomor Sertifikat Otomatis ---
        $year = Carbon::now()->year;
        // Hitung berapa banyak sertifikat di tahun yang sama
        $lastNumber = Sertifikat::where('nomor_sertifikat', 'like', "CERT/MANDIRI/{$year}/%")
            ->count();
        // Tambahkan padding "000" (contoh: jadi 0001)
        $sequence = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorSertifikat = "CERT/MANDIRI/{$year}/{$sequence}";

        // --- 2. Pengecekan Syarat Kelulusan ---
        
        // A. Cek laporan harian minimal 90 hari
        $laporans = \App\Models\LaporanHarian::where('siswa_id', $siswaId)
            ->orderBy('tanggal')
            ->get();

        if ($laporans->count() < 90) {
            return redirect()->back()->with('error', 'Gagal menerbitkan sertifikat: Siswa belum menyelesaikan minimal 90 hari laporan harian.');
        }

        // B. Cek laporan akhir disetujui
        $laporanAkhir = \App\Models\LaporanAkhir::where('siswa_id', $siswaId)->first();
        if (!$laporanAkhir || $laporanAkhir->status_verifikasi !== 'disetujui') {
            return redirect()->back()->with('error', 'Gagal menerbitkan sertifikat: Laporan Akhir siswa belum disetujui.');
        }

        // C. Cek nilai akhir (sidang sudah selesai)
        $nilai = \App\Models\NilaiPkl::where('siswa_id', $siswaId)->first();
        if (!$nilai || !$nilai->nilai_akhir) {
            return redirect()->back()->with('error', 'Gagal menerbitkan sertifikat: Siswa belum melaksanakan sidang atau belum mendapatkan nilai akhir.');
        }

        // --- 3. Ekstraksi Data Tambahan ---
        
        // Mengambil tanggal PKL mulai hingga selesai berdasarkan record jurnal harian pertama dan terakhir.
        $tanggalMulai = $laporans->first() 
            ? $laporans->first()->tanggal 
            : Carbon::now()->subMonths(3)->toDateString();
        $tanggalSelesai = $laporans->last() 
            ? $laporans->last()->tanggal 
            : Carbon::now()->toDateString();

        // Mengambil data tempat/tanggal lahir (jika sebelumnya sudah ada di database, sebagai fallback)
        $existing = Sertifikat::where('siswa_id', $siswaId)->first();
        $tempatLahir = $existing->tempat_lahir ?? 'Tangerang';
        $tanggalLahir = $existing->tanggal_lahir ?? '2008-01-01';

        // Override jika admin/guru mengisi dari request form (contoh jika ada pop-up konfirmasi detail lahir)
        if ($request->filled('tempat_lahir')) {
            $tempatLahir = $request->tempat_lahir;
        }
        if ($request->filled('tanggal_lahir')) {
            $tanggalLahir = $request->tanggal_lahir;
        }

        // --- 4. Simpan ke Database ---
        Sertifikat::updateOrCreate(
            ['siswa_id' => $siswaId],
            [
                'nomor_sertifikat' => $nomorSertifikat,
                'tempat_lahir' => $tempatLahir,
                'tanggal_lahir' => $tanggalLahir,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ]
        );

        return redirect()->route('pembimbing.sertifikat.index')->with('success', 'Sertifikat berhasil diterbitkan secara otomatis.');
    }
}
