<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model JadwalSidang
 * Menyimpan data jadwal presentasi/sidang PKL untuk setiap siswa.
 */
class JadwalSidang extends Model
{
    protected $fillable = ['siswa_id', 'penguji_id', 'pembimbing_id', 'waktu', 'ruangan'];

    /**
     * $casts digunakan untuk mengonversi format kolom 'waktu'
     * menjadi tipe objek tanggal (datetime/Carbon) agar mudah dimanipulasi (misal format jam/tanggal).
     */
    protected $casts = [
        'waktu' => 'datetime',
    ];

    /**
     * Relasi ke model Siswa. (Setiap jadwal milik satu siswa).
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke model Guru sebagai penguji sidang.
     */
    public function penguji()
    {
        return $this->belongsTo(Guru::class, 'penguji_id');
    }

    /**
     * Relasi ke model Guru sebagai pembimbing yang mendampingi sidang.
     */
    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id');
    }
}
