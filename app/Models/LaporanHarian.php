<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    protected $fillable = ['siswa_id', 'tanggal', 'kegiatan', 'bukti_foto', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
