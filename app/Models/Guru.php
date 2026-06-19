<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['user_id', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bimbingans()
    {
        return $this->hasMany(JadwalSidang::class, 'pembimbing_id');
    }

    public function ujians()
    {
        return $this->hasMany(JadwalSidang::class, 'penguji_id');
    }

    public function siswaBimbingan()
    {
        return $this->hasMany(Siswa::class, 'pembimbing_id');
    }
}
