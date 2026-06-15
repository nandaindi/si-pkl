<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pengajuans = PengajuanPkl::with(['siswa.user', 'tempatPkl'])
            ->when($search, function ($query, $search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('tempatPkl', function ($q) use ($search) {
                    $q->where('nama_instansi', 'like', "%{$search}%");
                });
            })
            ->latest()->get();
        return view('dashboard.pembimbing.pengajuan', compact('pengajuans'));
    }

    public function verifikasi(Request $request, PengajuanPkl $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan_ditolak' => 'required_if:status,ditolak|nullable|string|max:1000',
        ]);

        $status = $request->status;

        try {
            DB::transaction(function () use ($pengajuan, $status, $request) {
                $oldStatus = $pengajuan->status;
                $tempat = $pengajuan->tempatPkl;

                if ($status === 'disetujui') {
                    if ($oldStatus !== 'disetujui') {
                        if ($tempat->kuota <= 0) {
                            throw new \Exception('Kuota perusahaan ini sudah penuh.');
                        }
                        $tempat->decrement('kuota');
                    }
                } elseif ($status === 'ditolak') {
                    if ($oldStatus === 'disetujui') {
                        $tempat->increment('kuota');
                    }
                }

                $pengajuan->update([
                    'status' => $status,
                    'alasan_ditolak' => $status === 'ditolak' ? $request->alasan_ditolak : null,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->route('pembimbing.pengajuan.index')->with('error', $e->getMessage());
        }

        return redirect()->route('pembimbing.pengajuan.index')->with('success', 'Status pengajuan siswa berhasil diperbarui.');
    }
}
