<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    protected $fillable = ['siswa_id', 'file_laporan', 'status_verifikasi', 'catatan_pembimbing'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
