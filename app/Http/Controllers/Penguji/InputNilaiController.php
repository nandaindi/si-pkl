<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\NilaiPkl;

class InputNilaiController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $search = $request->input('search');
        $jadwals = $guru 
            ? JadwalSidang::where('penguji_id', $guru->id)
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'siswa.nilaiPkls'])->orderBy('waktu', 'asc')->get() 
            : collect();

        return view('dashboard.penguji.inputnilai', compact('jadwals'));
    }

    public function store(Request $request, JadwalSidang $sidang)
    {
        $request->validate([
            'nilai_penguji' => 'required|numeric|min:0|max:100',
        ]);

        $nilaiPkl = NilaiPkl::where('siswa_id', $sidang->siswa_id)->first();
        $nilai_pembimbing = $nilaiPkl ? $nilaiPkl->nilai_pembimbing : null;

        if ($nilai_pembimbing !== null) {
            $nilai_akhir = ($nilai_pembimbing + $request->nilai_penguji) / 2;
        } else {
            $nilai_akhir = $request->nilai_penguji;
        }

        NilaiPkl::updateOrCreate(
            ['siswa_id' => $sidang->siswa_id],
            [
                'nilai_penguji' => $request->nilai_penguji,
                'nilai_akhir' => $nilai_akhir,
            ]
        );

        if ($sidang->siswa && $sidang->siswa->user) {
            $sidang->siswa->user->notify(new \App\Notifications\PklNotification(
                'Nilai Sidang Masuk',
                "Guru Penguji telah memasukkan Nilai Sidang Anda.",
                '#',
                'award'
            ));
        }

        return redirect()->route('penguji.input-nilai.index')->with('success', 'Nilai penguji berhasil disimpan.');
    }
}
