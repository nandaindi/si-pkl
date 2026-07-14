<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Sertifikat
 * Menampung data sertifikat kelulusan PKL siswa.
 */
class Sertifikat extends Model
{
    protected $fillable = [
        'siswa_id',
        'file_sertifikat',
        'nomor_sertifikat',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    /**
     * Relasi ke model Siswa pemilik sertifikat.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
