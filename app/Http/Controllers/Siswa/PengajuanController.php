<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPkl;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan tempat PKL yang pernah dilakukan oleh siswa beserta statusnya.
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        // Pengecekan apakah siswa sudah pernah disetujui PKL nya di salah satu tempat
        $has_approved = PengajuanPkl::where('siswa_id', $siswa->id)->where('status', 'disetujui')->exists();

        $query = PengajuanPkl::where('siswa_id', $siswa->id)->with('tempatPkl')->latest();
        
        // Jika sudah ada yang disetujui, hanya tampilkan tempat PKL yang disetujui tersebut di view.
        if ($has_approved) {
            $query->where('status', 'disetujui');
        }
        
        $pengajuans = $query->paginate(10);

        return view('dashboard.siswa.pengajuan', compact('pengajuans', 'has_approved'));
    }

    /**
     * Menampilkan form untuk mengajukan tempat PKL baru.
     */
    public function create()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        // Cek jika status masih pending atau sudah disetujui, maka ga boleh mengajukan tempat baru lagi.
        $existing = PengajuanPkl::where('siswa_id', $siswa->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($existing) {
            return redirect()->route('siswa.pengajuan.index')->with('error', 'Anda sudah memiliki pengajuan yang aktif atau disetujui.');
        }

        // Menampilkan tempat PKL yang sisa kuotanya masih > 0
        // withCount digunakan untuk menghitung jumlah pengajuan yang 'disetujui' pada masing-masing tempat.
        $tempat_pkls = TempatPkl::withCount(['pengajuanPkls' => function ($q) {
            $q->where('status', 'disetujui');
        }])->get()->filter(function ($tempat) {
            return $tempat->kuota > $tempat->pengajuan_pkls_count;
        });
        
        return view('dashboard.siswa.pengajuan_create', compact('tempat_pkls'));
    }

    /**
     * Memproses pengajuan tempat PKL baru ke database.
     */
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $request->validate([
            'tempat_pkl_id' => 'required|exists:tempat_pkls,id',
        ]);

        $existing = PengajuanPkl::where('siswa_id', $siswa->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($existing) {
            return redirect()->route('siswa.pengajuan.index')->with('error', 'Anda sudah memiliki pengajuan yang aktif atau disetujui.');
        }

        $pengajuan = PengajuanPkl::create([
            'siswa_id' => $siswa->id,
            'tempat_pkl_id' => $request->tempat_pkl_id,
            'status' => 'pending', // Pengajuan baru selalu berstatus pending.
        ]);

        // Mengirimkan notifikasi ke Guru Pembimbing siswa ini (jika sudah diatur oleh admin)
        if ($siswa->pembimbing && $siswa->pembimbing->user) {
            $siswa->pembimbing->user->notify(new \App\Notifications\PklNotification(
                'Pengajuan PKL Baru',
                "{$siswa->user->name} mengajukan tempat PKL baru.",
                route('pembimbing.pengajuan.index'),
                'file-text'
            ));
        }

        return redirect()->route('siswa.pengajuan.index')->with('success', 'Pengajuan PKL berhasil dikirim. Menunggu persetujuan pembimbing.');
    }

    /**
     * Membatalkan pengajuan PKL jika status masih 'pending'.
     */
    public function destroy(PengajuanPkl $pengajuan)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa || $pengajuan->siswa_id != $siswa->id) {
            abort(403, 'Akses ditolak.'); // Error jika siswa mencoba menghapus pengajuan milik orang lain.
        }

        if ($pengajuan->status !== 'pending') {
            return redirect()->route('siswa.pengajuan.index')->with('error', 'Hanya pengajuan dengan status pending yang dapat dibatalkan.');
        }

        $pengajuan->delete();

        return redirect()->route('siswa.pengajuan.index')->with('success', 'Pengajuan PKL berhasil dibatalkan.');
    }
}
