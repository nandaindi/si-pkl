<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan tempat PKL dari siswa bimbingan.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pengajuans = PengajuanPkl::whereHas('siswa', function ($q) {
                // Filter hanya untuk siswa bimbingan guru yang login
                $q->where('pembimbing_id', auth()->user()->guru->id);
            })
            ->with(['siswa.user', 'tempatPkl'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('tempatPkl', function ($q) use ($search) {
                    $q->where('nama_instansi', 'like', "%{$search}%");
                });
            })
            ->latest()->paginate(10);
            
        return view('dashboard.pembimbing.pengajuan', compact('pengajuans'));
    }

    /**
     * Memverifikasi pengajuan PKL (Menerima atau Menolak).
     */
    public function verifikasi(Request $request, PengajuanPkl $pengajuan)
    {
        // Validasi: Kalau status 'ditolak', maka alasan wajib diisi (required_if).
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan_ditolak' => 'required_if:status,ditolak|nullable|string|max:1000',
        ]);

        $status = $request->status;

        try {
            DB::transaction(function () use ($pengajuan, $status, $request) {
                $oldStatus = $pengajuan->status;
                $tempat = $pengajuan->tempatPkl;

                // Logika Pengecekan Kuota
                // Kuota tidak otomatis dikurangi di sini, karena model TempatPkl menggunakan Accessor (getSisaKuotaAttribute)
                // untuk menghitung kuota yang terpakai dengan cara men-query tabel pengajuan_pkls.
                // Jadi, kita hanya perlu mengecek sisa kuota, lalu mengupdate status pengajuannya ke DB.
                if ($status === 'disetujui') {
                    if ($oldStatus !== 'disetujui') { // Jika sebelumnya tidak disetujui
                        if ($tempat->sisa_kuota <= 0) { // sisa_kuota adalah attribute/accessor dari model TempatPkl
                            throw new \Exception('Kuota perusahaan ini sudah penuh.'); // Lempar error ke blok catch
                        }
                    }
                }

                $pengajuan->update([
                    'status' => $status,
                    'alasan_ditolak' => $status === 'ditolak' ? $request->alasan_ditolak : null,
                ]);

                // Kirim notifikasi
                if ($pengajuan->siswa && $pengajuan->siswa->user) {
                    $msg = $status === 'disetujui' 
                           ? "Pengajuan PKL di {$tempat->nama_instansi} telah DISETUJUI." 
                           : "Pengajuan PKL di {$tempat->nama_instansi} DITOLAK.";
                    $icon = $status === 'disetujui' ? 'check-circle' : 'x-circle';
                    
                    $pengajuan->siswa->user->notify(new \App\Notifications\PklNotification(
                        'Status Pengajuan PKL',
                        $msg,
                        route('siswa.pengajuan.index'),
                        $icon
                    ));
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('pembimbing.pengajuan.index')->with('error', $e->getMessage());
        }

        return redirect()->route('pembimbing.pengajuan.index')->with('success', 'Status pengajuan siswa berhasil diperbarui.');
    }
}
