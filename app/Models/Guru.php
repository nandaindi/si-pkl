<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Guru
 * Merepresentasikan tabel 'gurus' di database.
 */
class Guru extends Model
{
    /**
     * $fillable menentukan kolom yang boleh diisi secara massal.
     */
    protected $fillable = ['user_id', 'nip'];

    /**
     * Relasi ke model User. Setiap guru memiliki satu akun (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke JadwalSidang (sebagai pembimbing).
     * Satu guru dapat menjadi pembimbing di banyak jadwal sidang.
     */
    public function bimbingans()
    {
        return $this->hasMany(JadwalSidang::class, 'pembimbing_id');
    }

    /**
     * Relasi ke JadwalSidang (sebagai penguji).
     * Satu guru dapat menguji di banyak jadwal sidang.
     */
    public function ujians()
    {
        return $this->hasMany(JadwalSidang::class, 'penguji_id');
    }

    /**
     * Relasi ke model Siswa.
     * Satu guru dapat membimbing banyak siswa.
     */
    public function siswaBimbingan()
    {
        return $this->hasMany(Siswa::class, 'pembimbing_id');
    }
}
