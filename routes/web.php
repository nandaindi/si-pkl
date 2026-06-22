<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $siswa_count = \App\Models\Siswa::count();
    $mitra_count = \App\Models\TempatPkl::count();
    $laporan_terbaru = \App\Models\LaporanHarian::with('siswa.user')->latest('tanggal')->take(3)->get();
    $mitra_list = \App\Models\TempatPkl::latest()->take(8)->get();
    $jadwal_sidang_terbaru = \App\Models\JadwalSidang::with(['siswa.user', 'penguji.user'])->latest()->first();

    if ($siswa_count == 0) $siswa_count = 152;
    if ($mitra_count == 0) $mitra_count = 32;

    return view('welcome', compact('siswa_count', 'mitra_count', 'laporan_terbaru', 'mitra_list', 'jadwal_sidang_terbaru'));
});

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        $user = request()->user();
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('pembimbing')) return redirect()->route('pembimbing.dashboard');
        if ($user->hasRole('penguji')) return redirect()->route('penguji.dashboard');
        if ($user->hasRole('siswa')) return redirect()->route('siswa.dashboard');
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('sertifikat/{sertifikat}/cetak', [\App\Http\Controllers\SertifikatCetakController::class, 'cetak'])->name('sertifikat.cetak');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
    Route::resource('guru-pembimbing', \App\Http\Controllers\Admin\GuruPembimbingController::class);
    Route::resource('guru-penguji', \App\Http\Controllers\Admin\GuruPengujiController::class);
    Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);
    Route::resource('tempat-pkl', \App\Http\Controllers\Admin\TempatPklController::class);
});

Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->name('pembimbing.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Pembimbing\HomeController::class, 'index'])->name('dashboard');
    Route::patch('pengajuan/{pengajuan}/verifikasi', [\App\Http\Controllers\Pembimbing\PengajuanController::class, 'verifikasi'])->name('pengajuan.verifikasi');
    Route::get('laporan-harian', [\App\Http\Controllers\Pembimbing\LaporanHarianController::class, 'index'])->name('laporan-harian.index');
    Route::get('laporan-harian/{siswa}', [\App\Http\Controllers\Pembimbing\LaporanHarianController::class, 'show'])->name('laporan-harian.show');
    Route::patch('laporan-harian/{laporan}/verifikasi', [\App\Http\Controllers\Pembimbing\LaporanHarianController::class, 'verifikasi'])->name('laporan-harian.verifikasi');
    Route::resource('pengajuan', \App\Http\Controllers\Pembimbing\PengajuanController::class)->except(['update']);
    Route::resource('laporan', \App\Http\Controllers\Pembimbing\LaporanController::class)->except(['update']);
    Route::resource('jadwal-sidang', \App\Http\Controllers\Pembimbing\JadwalSidangController::class);
    Route::resource('nilai', \App\Http\Controllers\Pembimbing\NilaiController::class);
    Route::resource('sertifikat', \App\Http\Controllers\Pembimbing\SertifikatController::class);
});

Route::middleware(['auth', 'role:penguji'])->prefix('penguji')->name('penguji.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Penguji\HomeController::class, 'index'])->name('dashboard');
    Route::get('jadwal-sidang', [\App\Http\Controllers\Penguji\JadwalSidangController::class, 'index'])->name('jadwal-sidang.index');
    Route::get('input-nilai', [\App\Http\Controllers\Penguji\InputNilaiController::class, 'index'])->name('input-nilai.index');
    Route::post('input-nilai/{sidang}', [\App\Http\Controllers\Penguji\InputNilaiController::class, 'store'])->name('input-nilai.store');
});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Siswa\HomeController::class, 'index'])->name('dashboard');
    Route::resource('pengajuan', \App\Http\Controllers\Siswa\PengajuanController::class);
    Route::resource('jurnal-harian', \App\Http\Controllers\Siswa\JurnalHarianController::class);
    Route::get('jurnal-harian-export', [\App\Http\Controllers\Siswa\JurnalHarianController::class, 'export'])->name('jurnal-harian.export');
    Route::get('laporan-akhir', [\App\Http\Controllers\Siswa\LaporanAkhirController::class, 'index'])->name('laporan-akhir.index');
    Route::post('laporan-akhir', [\App\Http\Controllers\Siswa\LaporanAkhirController::class, 'store'])->name('laporan-akhir.store');
    Route::get('jadwal-sidang', [\App\Http\Controllers\Siswa\JadwalSidangController::class, 'index'])->name('jadwal-sidang.index');
    Route::get('sertifikat', [\App\Http\Controllers\Siswa\SertifikatController::class, 'index'])->name('sertifikat.index');
    
    Route::get('surat-pengantar', [\App\Http\Controllers\Siswa\SuratPengantarController::class, 'index'])->name('surat-pengantar.index');
    Route::get('surat-pengantar/{pengajuan}/cetak', [\App\Http\Controllers\Siswa\SuratPengantarController::class, 'cetak'])->name('surat-pengantar.cetak');
});
