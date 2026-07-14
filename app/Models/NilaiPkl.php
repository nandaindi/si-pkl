<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model NilaiPkl
 * Menampung nilai akhir dari tempat PKL, pembimbing, dan/atau penguji sidang.
 */
class NilaiPkl extends Model
{
    protected $fillable = ['siswa_id', 'nilai_pembimbing', 'nilai_penguji', 'nilai_akhir'];

    /**
     * Relasi ke siswa yang mendapatkan nilai.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
