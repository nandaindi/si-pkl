<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiPkl extends Model
{
    protected $fillable = ['siswa_id', 'nilai_pembimbing', 'nilai_penguji', 'nilai_akhir'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
