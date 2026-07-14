<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model LaporanAkhir
 * Digunakan untuk mengelola pengumpulan file laporan akhir (PDF/Word) oleh siswa.
 */
class LaporanAkhir extends Model
{
    protected $fillable = ['siswa_id', 'file_laporan', 'status_verifikasi', 'catatan_pembimbing'];

    /**
     * Relasi ke Siswa pemilik laporan akhir ini.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
