<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model LaporanHarian (Jurnal Harian PKL)
 * Menyimpan kegiatan PKL harian yang diisi oleh siswa.
 */
class LaporanHarian extends Model
{
    protected $fillable = ['siswa_id', 'tanggal', 'kegiatan', 'bukti_foto', 'status'];

    /**
     * Relasi ke model Siswa pembuat laporan harian ini.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
