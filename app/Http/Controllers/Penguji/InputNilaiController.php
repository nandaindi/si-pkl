<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use App\Models\NilaiPkl;

class InputNilaiController extends Controller
{
    /**
     * Menampilkan daftar sidang yang menjadi tanggung jawab guru penguji ini 
     * (untuk diberikan nilai).
     */
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $search = $request->input('search');
        
        $jadwals = $guru 
            ? JadwalSidang::where('penguji_id', $guru->id)
                ->whereDoesntHave('siswa.sertifikat') // Hanya tampilkan yang belum lulus (belum bersertifikat)
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'siswa.nilaiPkls'])->orderBy('waktu', 'asc')->paginate(10) 
            : collect();

        return view('dashboard.penguji.inputnilai', compact('jadwals'));
    }

    /**
     * Menyimpan nilai sidang yang diberikan oleh guru penguji.
     */
    public function store(Request $request, JadwalSidang $sidang)
    {
        $request->validate([
            'nilai_penguji' => 'required|numeric|min:0|max:100',
        ]);

        $nilaiPkl = NilaiPkl::where('siswa_id', $sidang->siswa_id)->first();
        
        // Cek apakah guru pembimbing sudah memasukkan nilai
        $nilai_pembimbing = $nilaiPkl ? $nilaiPkl->nilai_pembimbing : null;

        // Logika perhitungan nilai akhir:
        if ($nilai_pembimbing !== null) {
            // Jika pembimbing sudah menilai, nilai akhirnya adalah rata-rata.
            $nilai_akhir = ($nilai_pembimbing + $request->nilai_penguji) / 2;
        } else {
            // Jika belum, gunakan nilai penguji ini sebagai nilai akhir sementara.
            $nilai_akhir = $request->nilai_penguji;
        }

        // Menyimpan / memperbarui nilai ke database
        NilaiPkl::updateOrCreate(
            ['siswa_id' => $sidang->siswa_id],
            [
                'nilai_penguji' => $request->nilai_penguji,
                'nilai_akhir' => $nilai_akhir,
            ]
        );

        // Notifikasi ke siswa
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
