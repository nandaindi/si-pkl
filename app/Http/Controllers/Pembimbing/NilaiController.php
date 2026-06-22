<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\NilaiPkl;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $search = $request->input('search');
        $jadwals = $guru
            ? JadwalSidang::where('pembimbing_id', $guru->id)
                ->whereDoesntHave('siswa.sertifikat')
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'siswa.nilaiPkls'])
                ->paginate(10)
            : collect();

        return view('dashboard.pembimbing.nilai', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nilai_pembimbing' => 'required|numeric|min:0|max:100',
        ]);

        $nilaiPkl = NilaiPkl::where('siswa_id', $request->siswa_id)->first();
        $nilai_penguji = $nilaiPkl ? $nilaiPkl->nilai_penguji : null;

        if ($nilai_penguji !== null) {
            $nilai_akhir = ($request->nilai_pembimbing + $nilai_penguji) / 2;
        } else {
            $nilai_akhir = $request->nilai_pembimbing;
        }

        NilaiPkl::updateOrCreate(
            ['siswa_id' => $request->siswa_id],
            [
                'nilai_pembimbing' => $request->nilai_pembimbing,
                'nilai_akhir' => $nilai_akhir,
            ],
        );

        $siswa = \App\Models\Siswa::find($request->siswa_id);
        if ($siswa && $siswa->user) {
            $siswa->user->notify(new \App\Notifications\PklNotification(
                'Nilai Bimbingan Masuk',
                "Guru Pembimbing telah memasukkan Nilai Bimbingan PKL Anda.",
                '#',
                'award'
            ));
        }

        return redirect()->route('pembimbing.nilai.index')->with('success', 'Nilai pembimbing berhasil disimpan.');
    }
}
