<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\TempatPkl;

class HomeController extends Controller
{
    public function index(Request $request)
    {
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
    }
}
