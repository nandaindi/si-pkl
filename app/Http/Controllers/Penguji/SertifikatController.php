<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;

class SertifikatController extends Controller
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
                ->with(['siswa.user', 'siswa.sertifikat'])->orderBy('waktu', 'asc')->get() 
            : collect();

        return view('dashboard.penguji.sertifikat', compact('jadwals'));
    }
}
