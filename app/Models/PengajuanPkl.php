<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPkl extends Model
{
    protected $fillable = ['siswa_id', 'tempat_pkl_id', 'status', 'alasan_ditolak'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tempatPkl()
    {
        return $this->belongsTo(TempatPkl::class);
    }
}
