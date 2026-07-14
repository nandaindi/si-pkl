<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    /**
     * Menampilkan sertifikat yang telah diterbitkan (Tanda Lulus PKL).
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil siswa belum dibuat.');
        }

        // Ambil data sertifikat milik siswa ini dari database.
        $sertifikat = Sertifikat::where('siswa_id', $siswa->id)->first();

        return view('dashboard.siswa.sertifikat', compact('sertifikat'));
    }
}
