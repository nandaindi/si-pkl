<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPkl;
use App\Models\PengajuanPkl;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $pengajuans = PengajuanPkl::where('siswa_id', $siswa->id)->with('tempatPkl')->latest()->get();
        $has_approved = $pengajuans->contains('status', 'disetujui');

        return view('dashboard.siswa.pengajuan', compact('pengajuans', 'has_approved'));
    }

    public function create()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat oleh admin.');
        }

        $existing = PengajuanPkl::where('siswa_id', $siswa->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($existing) {
            return redirect()->route('siswa.pengajuan.index')->with('error', 'Anda sudah memiliki pengajuan yang aktif atau disetujui.');
        }

        $tempat_pkls = TempatPkl::where('kuota', '>', 0)->get();
        return view('dashboard.siswa.pengajuan_create', compact('tempat_pkls'));
    }

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

        PengajuanPkl::create([
            'siswa_id' => $siswa->id,
            'tempat_pkl_id' => $request->tempat_pkl_id,
            'status' => 'pending',
        ]);

        return redirect()->route('siswa.pengajuan.index')->with('success', 'Pengajuan PKL berhasil dikirim. Menunggu persetujuan pembimbing.');
    }

    public function destroy(PengajuanPkl $pengajuan)
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa || $pengajuan->siswa_id !== $siswa->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($pengajuan->status !== 'pending') {
            return redirect()->route('siswa.pengajuan.index')->with('error', 'Hanya pengajuan dengan status pending yang dapat dibatalkan.');
        }

        $pengajuan->delete();

        return redirect()->route('siswa.pengajuan.index')->with('success', 'Pengajuan PKL berhasil dibatalkan.');
    }
}
