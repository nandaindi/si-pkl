<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSidang extends Model
{
    protected $fillable = ['siswa_id', 'penguji_id', 'pembimbing_id', 'waktu', 'ruangan'];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function penguji()
    {
        return $this->belongsTo(Guru::class, 'penguji_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
    }
}
