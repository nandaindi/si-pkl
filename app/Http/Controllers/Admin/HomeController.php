<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\TempatPkl;

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk admin.
     * Mengumpulkan berbagai metrik ringkasan (jumlah siswa, guru pembimbing, dll) untuk ditampilkan dalam bentuk card/chart.
     */
    public function index(Request $request)
    {
        $siswa_count = Siswa::count(); // Menghitung total seluruh siswa
        
        // Menghitung jumlah guru yang hanya berperan sebagai 'pembimbing'
        $pembimbing_count = Guru::whereHas('user', function ($q) {
            $q->role('pembimbing');
        })->count();
        
        // Menghitung jumlah guru yang berperan sebagai 'penguji'
        $penguji_count = Guru::whereHas('user', function ($q) {
            $q->role('penguji');
        })->count();
        
        $tempat_pkl_count = TempatPkl::count(); // Menghitung total tempat PKL
        
        // Menampilkan view dashboard dan mengirimkan semua variabel perhitungan di atas menggunakan compact().
        return view('dashboard.admin.index', compact(
            'siswa_count',
            'pembimbing_count',
            'penguji_count',
            'tempat_pkl_count'
        ));
    }
}
