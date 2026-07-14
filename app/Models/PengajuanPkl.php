<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model PengajuanPkl
 * Digunakan saat siswa mengajukan tempat PKL dan diproses oleh admin/pembimbing (disetujui/ditolak).
 */
class PengajuanPkl extends Model
{
    protected $fillable = ['siswa_id', 'tempat_pkl_id', 'status', 'alasan_ditolak'];

    /**
     * Relasi ke model Siswa yang melakukan pengajuan.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke model TempatPkl yang dipilih.
     */
    public function tempatPkl()
    {
        return $this->belongsTo(TempatPkl::class);
    }
}
