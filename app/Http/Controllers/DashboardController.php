<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\TempatPkl;
use App\Models\PengajuanPkl;
use App\Models\LaporanHarian;
use App\Models\JadwalSidang;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasRole('admin')) {
            $siswa_count = Siswa::count();
            $pembimbing_count = Guru::whereHas('user', function ($q) {
                $q->role('pembimbing');
            })->count();
            $penguji_count = Guru::whereHas('user', function ($q) {
                $q->role('penguji');
            })->count();
            $tempat_pkl_count = TempatPkl::count();
            
            return view('dashboard.admin.index', compact(
                'siswa_count',
                'pembimbing_count',
                'penguji_count',
                'tempat_pkl_count'
            ));
            
        } elseif ($user->hasRole('pembimbing')) {
            $guru = $user->guru;
            
            $bimbingan_sidang_count = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->count() : 0;
            $bimbingans = $guru ? JadwalSidang::where('pembimbing_id', $guru->id)->with('siswa.user')->get() : collect();
            $pending_pengajuan_count = PengajuanPkl::where('status', 'pending')->count();
            
            return view('dashboard.pembimbing.index', compact(
                'guru',
                'bimbingan_sidang_count',
                'bimbingans',
                'pending_pengajuan_count'
            ));
            
        } elseif ($user->hasRole('penguji')) {
            $guru = $user->guru;
            
            $ujian_sidang_count = $guru ? JadwalSidang::where('penguji_id', $guru->id)->count() : 0;
            $ujians = $guru ? JadwalSidang::where('penguji_id', $guru->id)->with('siswa.user')->get() : collect();
            
            return view('dashboard.penguji.index', compact(
                'guru',
                'ujian_sidang_count',
                'ujians'
            ));
            
        } elseif ($user->hasRole('siswa')) {
            $siswa = $user->siswa;
            
            $pengajuan_pkl = $siswa ? $siswa->pengajuanPkls()->with('tempatPkl')->latest()->first() : null;
            $laporan_harian_count = $siswa ? $siswa->laporanHarians()->distinct('tanggal')->count('tanggal') : 0;
            $jadwal_sidang = $siswa ? $siswa->jadwalSidangs()->with(['pembimbing.user', 'penguji.user'])->first() : null;
            $sertifikat = $siswa ? $siswa->sertifikat()->first() : null;
            
            $belum_isi_laporan_hari_ini = false;
            if ($siswa && $pengajuan_pkl && $pengajuan_pkl->status === 'disetujui') {
                if (\Carbon\Carbon::today()->isWeekday()) {
                    $laporan_hari_ini = $siswa->laporanHarians()->whereDate('tanggal', \Carbon\Carbon::today())->exists();
                    if (!$laporan_hari_ini) {
                        $belum_isi_laporan_hari_ini = true;
                    }
                }
            }
            
            return view('dashboard.siswa.index', compact(
                'siswa',
                'pengajuan_pkl',
                'laporan_harian_count',
                'jadwal_sidang',
                'sertifikat',
                'belum_isi_laporan_hari_ini'
            ));
        }

        return view('dashboard');
    }
}

