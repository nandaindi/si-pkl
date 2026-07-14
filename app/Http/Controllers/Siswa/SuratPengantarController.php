<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPkl;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SuratPengantarController extends Controller
{
    /**
     * Menampilkan halaman surat pengantar untuk siswa.
     */
    public function index()
    {
        // 1. Mengambil data siswa yang sedang login melalui relasi Auth::user()
        $siswa = Auth::user()->siswa;
        
        // Jika data siswa belum ada (belum diinput oleh admin), kembalikan ke dashboard dengan pesan error.
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        // 2. Mencari data pengajuan PKL milik siswa tersebut yang statusnya sudah 'disetujui'
        // with('tempatPkl') digunakan untuk memuat data relasi tempat PKL sekaligus (Eager Loading) agar query lebih efisien.
        // latest() mengurutkan dari yang paling baru, first() mengambil satu data teratas.
        $pengajuan = PengajuanPkl::where('siswa_id', $siswa->id)
            ->where('status', 'disetujui')
            ->with('tempatPkl')
            ->latest()
            ->first();

        // 3. Menampilkan view surat pengantar dan mengirimkan variabel $pengajuan ke view tersebut
        return view('dashboard.siswa.surat_pengantar', compact('pengajuan'));
    }

    /**
     * Mencetak surat pengantar berdasarkan ID pengajuan yang diberikan.
     */
    public function cetak(PengajuanPkl $pengajuan)
    {
        // 1. Mengambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;
        
        // 2. Validasi keamanan:
        // Pastikan siswa ada, dan pastikan ID siswa pada pengajuan PKL sama dengan ID siswa yang sedang login.
        // Ini mencegah siswa mencetak surat pengantar milik siswa lain (akses ditolak dengan error 403).
        if (!$siswa || $pengajuan->siswa_id != $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        // 3. Validasi status: Surat hanya bisa dicetak jika status pengajuannya sudah 'disetujui'
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->route('siswa.surat-pengantar.index')->with('error', 'Surat pengantar belum tersedia karena pengajuan belum disetujui.');
        }

        // 4. Mengambil ID tempat PKL dari pengajuan
        $tempat_pkl_id = $pengajuan->tempat_pkl_id;

        // 5. Membuat sebuah collection (kumpulan data) yang berisi satu siswa (yaitu siswa yang login)
        // Diperlukan jika tampilan view cetak mengharapkan bentuk list/kumpulan (biasanya dilooping).
        $siswa_list = collect([$siswa]);

        // 6. Menampilkan view khusus cetak surat pengantar dengan membawa data pengajuan dan daftar siswa
        return view('dashboard.pembimbing.surat_pengantar_cetak', compact('pengajuan', 'siswa_list'));
    }
}
