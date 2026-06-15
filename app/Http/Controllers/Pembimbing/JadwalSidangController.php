<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalSidang;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $search = $request->input('search');
        $jadwals = $guru 
            ? JadwalSidang::where('pembimbing_id', $guru->id)
                ->when($search, function ($query, $search) {
                    $query->whereHas('siswa.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->with(['siswa.user', 'penguji.user'])->orderBy('waktu', 'asc')->get() 
            : collect();

        return view('dashboard.pembimbing.jadwalsidang', compact('jadwals'));
    }
}
